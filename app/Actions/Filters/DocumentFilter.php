<?php

namespace App\Actions\Filters;

use App\Actions\Filters\QueryFilter;

class DocumentFilter extends QueryFilter
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
        $searchColumns = "title";

        return $this->builder->whereRaw("(CONCAT($searchColumns) LIKE ?)", ['%' . $str . '%']);
    }

    /**
     * Filter document based on a given status.
     *
     * @param String $status
     * @return Query Builder
     */
    public function status($status)
    {
        return $this->builder->whereStatus($status);
    }

    public function type($type)
    {
        if (empty($type)) {
            return true;
        }

        if ($type == 'purchase') {
            return $this->builder->whereIn('id', authUserOrgPurchasedDocumentIds());
        }

        return true;
    }

    /**
     * Filter document based on a given collection id.
     *
     * @param Char $collectionId
     * @return Query Builder
     */
    public function collection($collectionId)
    {
        return $this->builder->whereHas('documentCollections', function ($query) use ($collectionId) {
            $query->whereCollectionId($collectionId);
        });
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
            'title', 'organisation_id', 'status'
        ];
    }

}
