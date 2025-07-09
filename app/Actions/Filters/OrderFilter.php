<?php

namespace App\Actions\Filters;

use App\Actions\Filters\QueryFilter;

class OrderFilter extends QueryFilter
{
    /**
     * The order field associated with the filter.
     *
     * @var String
     */
    protected $orderField;

    /**
     * Filter document based on search columns.
     *
     * @param String $str
     * @return Query Builder
     */
    public function query($str = '')
    {
        if (empty($str)) {
            return true;
        }
        $searchColumns = "order_no";

        return $this->builder->whereRaw("(CONCAT($searchColumns) LIKE ?)", ['%' . $str . '%']);
    }

    /**
     * Set order column name.
     *
     * @param String $orderField
     * @return String
     */
    public function orderBy($orderField = 'created_at')
    {
        return $this->orderField = $orderField;
    }

    /**
     * Order the data based on order column.
     *
     * @param String $orderBy
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
     * @return Array
     */
    protected function orderColumns()
    {
        return [
            'order_no', 'organisation_id'
        ];
    }

}
