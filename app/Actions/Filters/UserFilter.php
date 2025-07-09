<?php 

namespace App\Actions\Filters;

use App\Actions\Filters\QueryFilter;

class UserFilter extends QueryFilter
{
    /**
     * The order field associated with the filter.
     * 
     * @var string
     */
    protected $orderField;

    /**
     * Filter users based on search columns.
     * 
     * @param  string $str
     * @return Query Builder
     */
    public function query($str = '')
    {
        if (empty($str)) {
            return true;
        }
        $searchColumns = "first_name, last_name, email, role, COALESCE(phone, ''), COALESCE(created_at, '')";

        return $this->builder->whereRaw("(CONCAT($searchColumns) LIKE ?)", ['%' . $str . '%']);
    }

    /**
     * Filter users based on a given status.
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
            'first_name', 'last_name', 'username', 'email', 'role', 'status'
        ];
    }

}