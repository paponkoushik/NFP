<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Actions\Filters\CategoryFilter;
use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    public function getAllCategories(CategoryFilter $filters): Collection
    {
        return Category::filter($filters)->ofActive()->getOptionsList();
    }
}
