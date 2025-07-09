<?php

namespace App\Actions\Filters;

use App\Actions\Filters\QueryFilter;

class CategoryFilter extends QueryFilter
{
    /**
     * The order field associated with the filter.
     *
     * @var string
     */
    protected $orderField;

    /**
     * Filter collection based on search columns.
     *
     * @param string $str
     * @return Query Builder
     */
    public function search($str = '')
    {
        if (empty($str)) {
            return true;
        }
        return $this->builder->where(function ($query) use ($str) {
            $query->where('name', 'LIKE', '%' . $str . '%')
                ->orWhereHas(
                    'parent',
                    fn($query) => $query->where('name', 'LIKE', '%' . $str . '%')
                );
        });
    }

    /**
     * Return main category.
     *
     * @return Query Builder
     */
    public function parentCategory()
    {
        return $this->builder->whereNull('parent_id');
    }

    /**
     * Return main category.
     *
     * @param String $parentId
     * @return Query Builder
     */
    public function parent($parentId)
    {
        return $this->builder->whereParentId($parentId);
    }

    /**
     * Filter collection based on a given status.
     *
     * @param string $status
     * @return Query Builder
     */
    public function status($status)
    {
        return $this->builder->whereStatus($status);
    }

    /**
     * Set order column name.
     *
     * @param string $orderField
     * @return string
     */
    public function orderBy($orderField = 'created_at')
    {
        return $this->orderField = $orderField;
    }

    /**
     * Order the data based on order column.
     *
     * @param string $orderBy
     * @return Query Builder
     */
    public function direction($orderBy = 'desc')
    {
        if (!in_array($this->orderField, $this->orderColumns())) {
            return true;
        }

        return $this->builder->orderBy("$this->orderField", $orderBy);
    }

    /**
     * Order column list.
     *
     * @return array
     */
    protected function orderColumns()
    {
        return [
            'title', 'organisation_id', 'status'
        ];
    }

}
