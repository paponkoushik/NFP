<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Actions\Filters\OrgFilter;
use App\Http\Resources\Org\OrgListResource;
use App\Models\Organisation;
use App\Services\OrganizationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Actions\Filters\OrganisationFilter;
use App\Http\Resources\OrganisationResource;

class OrganisationController extends Controller
{
    protected $service;

    public function __construct(OrganizationService $organizationService)
    {
        $this->service = $organizationService;
    }

    public function index(): View
    {
        return view('organisations.index');
    }

    public function getOrganisationList(OrgFilter $orgFilter): AnonymousResourceCollection
    {
        $organisations = Organisation::query()
            ->latest()
            ->with(['categories', 'preferences', 'otherLocations'])
            ->filter($orgFilter)->paginate(request('limit') ?? PAGINATE_LIMIT);

        return OrgListResource::collection($organisations);

    }

    public function getOrganisations(OrganisationFilter $filters): AnonymousResourceCollection
    {
        return OrganisationResource::collection(
            Organisation::with(['subscription', 'primaryAddress', 'users'])->filter($filters)->latest()->get()
        );
    }

    public function getAuthOrg(): JsonResponse
    {
        return response()->json(['authOrg' => authUserOrgId()]);
    }

    public function store(Request $request): JsonResponse
    {

        $this->service->validateRequest($request);

        try {
            DB::transaction(function () {
                $this->service
                    ->store()
                    ->createLocation()
                    ->createSubscription()
                    ->sendMail();
            });

            return response()->json(['message' => 'Organisation successfully created.'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => FAIL], 500);
        }
    }

    public function update(Request $request, Organisation $organisation_management): JsonResponse
    {
        $this->service->validateUpdateRequest($request, $organisation_management);

        try {

            DB::transaction(function () use ($request, $organisation_management) {
                $this->service
                    ->setModel($organisation_management)
                    ->update()
                    ->updateLocation()
                    ->updateSubscription();
            });

            // event(new OrganisationCreated($request->all(), $organisation->id));

            return response()->json(['message' => 'Organisation successfully updated.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(int | string $id): JsonResponse
    {
        try {
            Organisation::findOrFail($id)->delete();

            return response()->json(['message' => DELETE_SUCCESS]);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    public function deleteFile(Request $request): JsonResponse
    {
        try {
            if (! $request->id && $request->path) {
                Storage::delete($request->path);
                return response()->json(['message' => "File successfully deleted."], 200);
            }
            $organisation = Organisation::findOrFail($request->id);

            if (Storage::delete($request->path)) {
                $organisation->update(['logo' => null]);
            }

            return response()->json(['message' => "File successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
