<?php

namespace App\Http\Controllers\Category;

use App\Actions\Filters\CategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategorySelect2Resource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    public function index(): View
    {
        $excludeFields      = CategoryService::EXCLUDE_FIELDS;
        $excludeFieldValues = CategoryService::EXCLUDE_FIELD_VALUES;
        return view('categories.index', compact('excludeFields', 'excludeFieldValues'));
    }

    public function getAllCategories(CategoryFilter $filters): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::filter($filters)->with('parent')->ofActive()->latest()->paginate(request('limit') ?? PAGINATE_LIMIT)
        );
    }

    public function getSelect2ParentCategories(Request $request): JsonResponse
    {
        $categories = Category::query()->ofActive();
        if ($request->has('q')) {
            $categories->where('name', 'like', '%' . $request->get('q') . '%');
        }
        return response()->json([
            'results' => CategorySelect2Resource::collection($categories->get()),
        ], Response::HTTP_OK);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            if ($request->parent_id) {
                $data['parent_id'] = $request->parent_id;
            }

            if ($request->exclude_fields) {
                $data['exclude_fields'] = $request->exclude_fields;
            }

            if ($request->exclude_field_values) {
                $data['exclude_field_values'] = $request->exclude_field_values;
            }

            if ($request->custom_label) {
                $data['custom_label'] = $request->custom_label;
            }

            $data['created_by'] = auth()->id();

            Category::create($data);

            return respond('Category created successfully.', 201);
        } catch (\Exception $e) {
            return respondError(FAIL);
        }
    }

    public function show(Category $category): CategoryResource
    {
        $category->load('parent');
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $data = $request->validated();
            if ($request->parent_id) {
                $data['parent_id'] = $request->parent_id;
            }

            if ($request->exclude_fields && count($request->exclude_fields)) {
                $data['exclude_fields'] = $request->exclude_fields;
            }

            if ($request->exclude_field_values && count($request->exclude_field_values)) {
                $data['exclude_field_values'] = $request->exclude_field_values;
            }

            if ($request->custom_label) {
                $data['custom_label'] = $request->custom_label;
            }

            $category->update($data);

            return respond('Category updated successfully.');
        } catch (\Exception $e) {
            return respondError(UPDATE_FAIL);
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            $category->delete();

            return respond(DELETE_SUCCESS);
        } catch (\Exception $e) {
            return respondError(DELETE_FAIL);
        }
    }
}
