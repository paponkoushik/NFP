<?php 

namespace App\Actions\Filters;

use App\Actions\Filters\QueryFilter;

class OrganisationFilter extends QueryFilter
{
    /**
     * The order field associated with the filter.
     * 
     * @var string
     */
    protected $orderField;

    /**
     * Filter organisations based on search columns.
     * 
     * @param  string $str
     * @return Query Builder
     */
    public function query($str = '')
    {
        if (empty($str)) {
            return true;
        }
        $searchColumns = "org_name, org_type, COALESCE(contact_email, ''), COALESCE(contact_phone, '')";

        return $this->builder->whereRaw("(CONCAT($searchColumns) LIKE ?)", ['%' . $str . '%']);
    }

    /**
     * Filter organisations based on a given status.
     * 
     * @param  string $status
     * @return Query Builder
     */
    public function status($status)
    {
        return $this->builder->whereStatus($status);
    }

    /**
     * Set order column name.
     * 
     * @param  string $orderField
     * @return string
     */
    public function orderBy($orderField = 'created_at')
    {
        return $this->orderField = $orderField;
    }

    /**
     * Order the data based on order column.
     * 
     * @param  string $orderBy
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
            'industry_id', 'org_name', 'org_type', 'contact_email', 'address', 'city', 'status'
        ];
    }

}