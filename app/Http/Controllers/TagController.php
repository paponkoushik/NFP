<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Actions\Filters\TagFilter;
use App\Http\Resources\TagResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(): View
    {
        return view('tag.index');
    }

    public function getTags(TagFilter $filters): AnonymousResourceCollection
    {
        return TagResource::collection(
            Tag::filter($filters)->latest()->paginate(request('limit') ?? PAGINATE_LIMIT)
        );
    }

    public function getTagOptions(TagFilter $filters): array
    {
        return Tag::filter($filters)->latest()->pluck('id', 'name')->toArray();
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z_-]*$/|unique:tags',
        ], $this->message());

        try {
            Tag::create($request->only('name'));
            Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully created."], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => FAIL], 500);
        }
    }

    public function update(Request $request, int | string $id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z_-]*$/|unique:tags,name,' . $id . '',
        ], $this->message());

        try {
            Tag::findOrFail($id)->update($request->only('name'));
            Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully updated."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => UPDATE_FAIL], 500);
        }
    }


    public function destroy(int | string $id): JsonResponse
    {
        try {
           Tag::findOrFail($id)->delete();
           Tag::cacheFlush();

            return response()->json(['message' => "Tag successfully deleted."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => DELETE_FAIL], 500);
        }
    }

    protected function message(): array
    {
        return [
            'name.regex' => 'The :attribute field can contain alphabetic character, dash and underscore.',
        ];
    }

}
