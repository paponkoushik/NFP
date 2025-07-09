<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = CategoryService::CATEGORIES;

        $categoryFieldLabels = CategoryService::CUSTOM_LABELS;

        // fields - type, where, when, cost, summary
        $excludeFields = CategoryService::CATEGORY_EXCLUDE_FIELDS;

        $excludeFieldValues = CategoryService::CATEGORY_EXCLUDE_FIELD_VALUES;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($categories as $categoryName => $subCategories) {
            if ($categoryName == 'Collaboration' || $categoryName == 'Potential Merger') {
                $category = Category::create([
                    'name' => $categoryName,
                    'code' => Str::slug($categoryName),
                    'exclude_for' => 'inv'
                ]);
            } else {
                $category = Category::create([
                    'name' => $categoryName,
                    'code' => Str::slug($categoryName)
                ]);
            }


            // Check array_key_exists in $excludeFields
            $this->updateExcludeFields($category, $excludeFields);

            // Check array_key_exists in $excludeFieldValues
            $this->updateExcludeFieldValues($category, $excludeFieldValues);

            // Check array_key_exists in $customLabel
            $this->updateCustomLabel($category, $categoryFieldLabels);

            if (count($subCategories)) {
                $this->createSubCategories($category, $subCategories, $excludeFields, $excludeFieldValues, $categoryFieldLabels);
            }
        }

        $this->command->info('Categories seeded!');
    }

    protected function createSubCategories($category, $subCategories, $excludeFields, $excludeFieldValues, $customLabels)
    {
        foreach ($subCategories as $subCategoryName => $subSubCategories) {
            $subCategory = Category::create([
                'name'      => $subCategoryName,
                'code'      => Str::slug($subCategoryName),
                'parent_id' => $category->id
            ]);

            // Check array_key_exists in $excludeFields
            $this->updateExcludeFields($subCategory, $excludeFields);

            // Check array_key_exists in $excludeFieldValues
            $this->updateExcludeFieldValues($subCategory, $excludeFieldValues);

            // Check array_key_exists in $customLabel
            $this->updateCustomLabel($subCategory, $customLabels);

            if (count($subSubCategories)) {
                $this->createSubSubCategories($subCategory, $subSubCategories, $excludeFields, $excludeFieldValues, $customLabels);
            }
        }
    }

    protected function createSubSubCategories($subCategory, $subSubCategories, $excludeFields, $excludeFieldValues, $customLabels)
    {
        foreach ($subSubCategories as $subSubCategoryName) {
            $subSubCategory = Category::create([
                'name'      => $subSubCategoryName,
                'code'      => Str::slug($subCategory->name . "-" . $subSubCategoryName),
                'parent_id' => $subCategory->id
            ]);

            // Check array_key_exists in $excludeFields
            $this->updateExcludeFields($subSubCategory, $excludeFields);

            // Check array_key_exists in $excludeFieldValues
            $this->updateExcludeFieldValues($subSubCategory, $excludeFieldValues);

            // Check array_key_exists in $customLabel
            $this->updateCustomLabel($subSubCategory, $customLabels);
        }
    }

    protected function updateExcludeFields($category, $excludeFields)
    {
        if (array_key_exists($category->name, $excludeFields)) {
            $category->update([
                'exclude_fields' => $excludeFields[$category->name]
            ]);
        }
    }

    protected function updateExcludeFieldValues($category, $excludeFieldValues)
    {
        if (array_key_exists($category->name, $excludeFieldValues)) {
            $category->update([
                'exclude_field_values' => $excludeFieldValues[$category->name]
            ]);
        }
    }

    public function updateCustomLabel($category, $customLabels)
    {
        if (array_key_exists($category->name, $customLabels)) {
            $category->update([
                'custom_label' => $customLabels[$category->name]
            ]);
        }
    }
}
