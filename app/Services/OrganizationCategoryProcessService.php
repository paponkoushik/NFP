<?php

namespace App\Services;

class OrganizationCategoryProcessService
{
    private array $groupedCategories = [];
    private array $groupedCategoryExcludeFields = [];
    private array $groupedCategoryExcludeFieldValues = [];
    private array $groupedCustomLabels = [];

    /**
     * @param $categories
     * @return $this
     */
    public function processCategories($categories): static
    {
        $categories->each(function ($category) {
            $this->processCategory($category);
        });
        return $this;
    }

    /**
     * @param $category
     * @return void
     */
    private function processCategory($category): void
    {
        $category->load('parent.parent');

        $parent      = $category->parent;
        $grandParent = $category->parent ? $category->parent->parent : null;

        $categoryName       = $category->name;
        $excludeFields      = $category->exclude_fields;
        $excludeFieldValues = $category->exclude_field_values;
        $customLabels       = $category->custom_label;

        if ($grandParent) {
            $this->groupedCategories[$grandParent->code][$parent->code][]                                = $categoryName;
            $this->groupedCategoryExcludeFields[$grandParent->code][$parent->code][$category->code]      = $excludeFields;
            $this->groupedCategoryExcludeFieldValues[$grandParent->code][$parent->code][$category->code] = $excludeFieldValues;
            $this->groupedCustomLabels[$grandParent->code][$parent->code][$category->code]               = $customLabels;
        } elseif ($parent) {
            $this->groupedCategories[$parent->code][$category->code]                 = $categoryName;
            $this->groupedCategoryExcludeFields[$parent->code][$category->code]      = $excludeFields;
            $this->groupedCategoryExcludeFieldValues[$parent->code][$category->code] = $excludeFieldValues;
            $this->groupedCustomLabels[$parent->code][$category->code]               = $customLabels;
        } else {
            $this->groupedCategories[$category->code]                 = $categoryName;
            $this->groupedCategoryExcludeFields[$category->code]      = $excludeFields;
            $this->groupedCategoryExcludeFieldValues[$category->code] = $excludeFieldValues;
            $this->groupedCustomLabels[$category->code]               = $customLabels;
        }

    }

    /**
     * @return array
     */
    public function getGroupedCategories(): array
    {
        return $this->groupedCategories;
    }

    /**
     * @return array
     */
    public function getGroupedCategoryExcludeFields(): array
    {
        return $this->groupedCategoryExcludeFields;
    }

    /**
     * @return array
     */
    public function getGroupedCategoryExcludeFieldValues(): array
    {
        return $this->groupedCategoryExcludeFieldValues;
    }

    public function getGroupedCustomLabels(): array
    {
        return $this->groupedCustomLabels;
    }
}
