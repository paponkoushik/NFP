<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Actions\Filters\CollectionFilter;
use App\Http\Resources\CollectionResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CollectionController extends Controller
{
    public function index(): View
    {
        return view('collection.index');
    }

    public function getCollections(CollectionFilter $filters): AnonymousResourceCollection
    {
        return CollectionResource::collection(
            Collection::with('childs.childs')->filter($filters)->byParent()->oldest('title')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        try {
            $input = $request->only('title', 'parent_id');
            // $input['organisation_id'] = authUserOrgId();
            Collection::create($input);

            return response()->json(['message' => 'Collection successfully created.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string | int $id): JsonResponse
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        try {
            $collection = Collection::findOrFail($id);
            $input = $request->only('title', 'parent_id');
            // $input['organisation_id'] = authUserOrgId();
            $collection->update($input);

            return response()->json(['message' => 'Collection successfully updated.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL], 500);
        }
    }

    public function destroy(int | string $id): JsonResponse
    {
        try {
            $collection = Collection::with('childs.childs')->findOrFail($id);
            $collection->delete();

            return response()->json(['message' => DELETE_SUCCESS], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }
}
