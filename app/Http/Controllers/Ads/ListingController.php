<?php

namespace App\Http\Controllers\Ads;

use App\Models\Listing;
use App\Models\Location;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Filters\ListingFilter;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Listing\ListingResource;
use Illuminate\Validation\ValidationException;

class ListingController extends Controller
{

    public function index(): View
    {
        return view('posts.index');
    }

    public function getListings(ListingFilter $filters): AnonymousResourceCollection
    {
        $listings = Listing::loadRelation()
            ->filter($filters)
            ->latest()
            ->paginate(request('limit') ?? PAGINATE_LIMIT);

        return ListingResource::collection($listings);
    }

    public function create(): View
    {
        $locations  = Location::getOptionsList();
        $categories = Category::getParentsWithChilds();
        return view('posts.form', compact('locations', 'categories'));
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, $this->rules());

        try {
            $listing = Listing::create($this->setData($request));

            // Set preferences
            $this->setPreference($listing, $request->preferences);

            return response()->json(['message' => 'Post successfully created.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, string $id): View
    {
        $listing = Listing::loadRelation()->findOrFail($id);

        if ($listing->organisation->id != authUserOrgId()) {
            $listing->increment('visits');
        }

        return view('posts.show', [
            'post' => (
            new ListingResource($listing->load('location'))
            )->additional([
                    'canVisibleToSupport' => $request->user()->can('post-legal-support', $id)
                ])
        ]);
    }

    public function edit(string $postId): View|RedirectResponse
    {
        try {
            $post       = new ListingResource(Listing::loadRelation()->findOrFail($postId));
            $locations  = Location::getOptionsList();
            $categories = Category::getParentsWithChilds();
            return view('posts.form', compact('post', 'locations', 'categories'));
        } catch (Exception $e) {
            flash('Post not found!', 'danger');
            return redirect()->to('/posts');
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validate($request, $this->rules());

        try {
            $payload = Listing::findOrFail($id);
            $input   = $this->setData($request);

            $oldImages       = $this->getOldImagesPath($request->old_images);
            $input['images'] = array_merge($oldImages, $input['images']);
            // unique images
            $input['images'] = array_unique($input['images']);
            $input['images'] = array_values($input['images']);
            $payload->update($input);

            // Set preferences
            $this->setPreference($payload, $request->preferences);

            return response()->json(['message' => UPDATE_SUCCESS]);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL, 'original' => $e->getMessage()], 500);
        }
    }

    protected function getOldImagesPath($images): array
    {
        $oldImages = $images ?? [];

        if (count($oldImages) > 0) {
            foreach ($oldImages as &$imagePath) {
                $imagePath = str_replace('/storage/', '', $imagePath);
            }
        }

        return $oldImages;
    }

    public function destroy($id)
    {
        try {
            $listing = Listing::findOrFail($id);

            if (count($listing->images)) {
                foreach ($listing->images as $image) {
                    deleteFile($image);
                }
            }

            $listing->delete();

            return response()->json(['message' => DELETE_SUCCESS]);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    protected function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required',
            'description' => 'required',
            'type'        => 'required',
            'postcode'    => 'required',
            'city'        => 'required',
            'state'       => 'required',

        ];
    }

    protected function setData(Request $request): array
    {
        $input = $request->only([
            'category_id',
            'title',
            'description',
            'type',
            'address',
            'postcode',
            'city',
            'state'
        ]);

        $location = Location::query()
            ->where('locality', $request->city)
            ->where('postcode', $request->postcode)
            ->where('state', $request->state)
            ->first();

        $input['status']          = $request->status ?? 'open';
        $input['location_id']     = $location?->id ? $location->id : null;
        $input['slug']            = Str::slug($request->title);
        $input['organisation_id'] = authUserOrgId();
        $input['is_anonymous']    = $request->is_anonymous ?? false;
        $input['images']          = [];

        if ($request->images && count($request->images)) {
            // remove first slash from path
            foreach ($request->images as $imagePath) {
                // check image path is starts with /storage, then remove it
                // check image path is start with / or not, if then remove it
                $imagePath         = str_replace('/storage/', '', $imagePath);
                $imagePath         = ltrim($imagePath, '/');
                $input['images'][] = $imagePath;
            }
        }

        return $input;
    }

    protected function setPreference(Listing $listing, $preferences): void
    {
        if ($preferences && count($preferences) && isset($preferences['where'])) {
            $listingPref = $listing->preference()->updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'where'           => $preferences['where'],
                    'radius'          => $preferences['radius'] ?? null,
                    'radius_location' => $preferences['radius_location'] ?? null,
                    'when'            => $preferences['when'] ?? null,
                    'date'            => $preferences['date'] ?? null,
                    'from_date'       => $preferences['from_date'] ?? null,
                    'to_date'         => $preferences['to_date'] ?? null,
                    'cost'            => $preferences['cost'] ?? null,
                    'amount'          => $preferences['amount'] ?? null,
                    'from_amount'     => $preferences['from_amount'] ?? null,
                    'to_amount'       => $preferences['to_amount'] ?? null,
                    'frequency'       => $preferences['frequency'] ?? null,
                    'lat'             => $preferences['lat'] ?? null,
                    'long'            => $preferences['long'] ?? null,
                    'location_id'     => $preferences['location_id'] ?? null,
                ]
            );

            // set states
            $listingPref->stateList()->delete();
            if (isset($preferences['states']) && count($preferences['states'])) {
                foreach ($preferences['states'] as $state) {
                    $listingPref->stateList()->create(['state' => $state]);
                }
            }

            // set suburbs
            $listingPref->suburbList()->delete();
            if (isset($preferences['suburbs']) && count($preferences['suburbs'])) {
                foreach ($preferences['suburbs'] as $suburb) {
                    $listingPref->suburbList()->create(['suburb' => $suburb]);
                }
            }
        }
    }

    public function storeImage(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            return respondError('There is no file present', 400);
        }

        $request->validate([
            'file' => 'required|file|image'
        ]);

        try {
            $uploadFile = $request->file('file');
            $uploadDir  = authUserOrgId() . '/posts';
            $path       = $uploadFile->store($uploadDir, 'public');

            if (!$path) {
                return respondError('The file could not be saved.');
            }

            return response()->json($path);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    public function deletePostImage(Request $request): JsonResponse
    {
        try {
            $data    = json_decode($request->getContent());
            $listing = null;
            if (isset($data->post_id)) {
                $listing = Listing::find($data->post_id);
            }
            $filePath = str_replace('/storage', '/storage/app/public', $data->path);

            if (Storage::delete($filePath)) {
                if ($listing) {
                    $images = $listing->images;

                    $path = str_replace('/storage/', '', $data->path);
                    if (($key = array_search($path, $images)) !== false) {
                        unset($images[$key]);
                    }

                    $listing->update(['images' => $images]);
                }
            }

            return response()->json(['message' => 'File successfully deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
