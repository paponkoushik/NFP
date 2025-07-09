<?php

namespace App\Http\Controllers\Document;

use App\Models\User;
use App\Models\Document;
use App\Models\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Actions\Filters\CollectionFilter;
use App\Http\Resources\CollectionResource;
use App\Actions\Repository\DocumentRepository;

class DocumentManagementController extends Controller
{
    protected $documentRepo;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepo = $documentRepository;
    }

    public function index(): View
    {
        return view('document-management.index');
    }

    public function getDocumentCollections(CollectionFilter $filters): AnonymousResourceCollection
    {
        return CollectionResource::collection(
            Collection::loadRelation()->filter($filters)->byParent()->oldest('title')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate($this->rules($request));

        try {
            $this->documentRepo->create($request->all());

            return response()->json(['message' => "Document successfully created."], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate($this->rules($request));

        try {
            $this->documentRepo->update($request->all(), $id);

            return response()->json(['message' => "Document updated successfully."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $document = Document::findOrFail($id);
            if ($document->delete() && $document->file_type != 'link') {
                 $filePath = storage_path($document->path);
                $this->documentRepo->deleteFile($filePath);
            }

            return response()->json(['message' => "Document successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    public function deleteFile(Request $request): JsonResponse
    {
        try {
            $document = Document::findOrFail($request->id);
            $filePath = storage_path($document->path);
            $document->update(['path' => null]);
            return $this->documentRepo->deleteFile($filePath);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function accessDocument(string $encryptedId)
    {
        try {
            $decodedId = Crypt::decrypt($encryptedId);
            $userInfo = User::with('organisationUser.organisation')->find(\Auth::id());

            if (!$userInfo || !$userInfo->relationLoaded('organisationUser') || !$userInfo->organisationUser->relationLoaded('organisation')) {
                return response()->json(['message' => 'No relationship found for this user and organization.'], 404);
            }

            $orgUserHash = $userInfo->organisationUser->organisation->user_hash;

            if ($orgUserHash !== Session::get('user_hash')) {
                return response()->json(['message' => 'Access denied.'], 403);
            }

            $documentInfo = Document::find($decodedId);

            if (!$documentInfo) {
                return response()->json(['message' => 'No documents found for this user and organization.'], 404);
            }

            if (strpos($documentInfo->path, 'private/documents') !== false) {
                return response()->download(storage_path($documentInfo->path));
            } else {
                return redirect($documentInfo->path);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }

    protected function rules(Request $request): array
    {
        return [
            'title' => 'required|string|max:150',
            'collections' => 'required',
            'price' => [
                Rule::requiredIf($request->is_free == "false"),
            ],
            'external_link' => [
                Rule::requiredIf($request->is_external_link == "true"),
            ],
            'path' => [
                Rule::requiredIf($request->is_external_link == "false"),
            ],
        ];
    }
}
