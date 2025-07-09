<?php

namespace App\Actions\Filters;

class LegalRequestFilter extends QueryFilter
{
    /**
     * Filter users based on search columns.
     *
     * @param  string $str
     * @return Query Builder
     */
    public function search(string $str)
    {
        return $this->builder->where(
            fn ($query) => $query->where('request_no', 'LIKE', '%' . $str . '%')
            ->orWhereHas(
                'primaryOrg',
                fn ($query) => $query->where('org_name', 'LIKE', '%' . $str . '%')
            )
        );
    }

    /**
     * Filter users based on a given status.
     *
     * @param  string $status
     * @return Query Builder
     */
    public function status(string $status)
    {
        return $this->builder->whereWorkflowStatus($status);
    }

    /**
     * Order the data based on order column.
     *
     * @param  string $orderBy
     * @return Query Builder
     */
    public function sortBy(string $column)
    {
        $dateColumn = $this->filterColumns()[$column] ?? 'created_at';

        return $this->builder->orderBy($dateColumn, $this->request->direction ?? 'desc');
    }

    /**
     * Get start and end date wise file
     * @param  string $endDate
     * @return Query Builder
     */
    public function fromDate(string $fromDate)
    {
        $dateColumn = $this->filterColumns()[$this->request->dateColumn] ?? 'requested_date';

        if (!$this->request->toDate) {
            return $this->builder->whereDate($dateColumn, '>=', dateFormat($fromDate, 'Y-m-d', '-'));
        }

        return $this->dateFilterFormat($dateColumn, $fromDate, $this->request->toDate);
    }

    /**
     * Get start and end date wise file
     * @param  string $toDate
     * @return Query Builder
     */
    public function toDate(string $toDate)
    {
        $dateColumn = $this->filterColumns()[$this->request->dateColumn] ?? 'requested_date';

        if (!$this->request->fromDate) {
            return $this->builder->whereDate($dateColumn, '>=', dateFormat($toDate, 'Y-m-d', '-'));
        }

        return $this->dateFilterFormat($dateColumn, $this->request->fromDate, $toDate);
    }

    /**
     * filter by where between
     *
     * @param string $field
     * @param date $start
     * @param date $end
     *
     * @return Query Builder
     */
    protected function dateFilterFormat(string $field, $start, $end)
    {
        if (!empty($start) && empty($end)) {
            $from = dateFormat($start, 'Y-m-d', '-') . ' 00:00:00';
            $to = dateFormat($start, 'Y-m-d', '-') . ' 23:59:59';
        } elseif (empty($start) && !empty($end)) {
            $from = dateFormat($end, 'Y-m-d', '-') . ' 00:00:00';
            $to = dateFormat($end, 'Y-m-d', '-') . ' 23:59:59';
        } elseif (!empty($start) && !empty($end)) {
            $from = dateFormat($start, 'Y-m-d', '-') . ' 00:00:00';
            $to = dateFormat($end, 'Y-m-d', '-') . ' 23:59:59';
        }

        return $this->builder->whereBetween($field, [$from, $to]);
    }

    /**
     * filters column list.
     *
     * @return array
     */
    protected function filterColumns()
    {
        return [
            'requested' => 'requested_date',
            'offered' => 'offered_date',
            'agreed' => 'agreed_date',
            'completed' => 'completed_date',
            'created' => 'created_at',
            'updated' => 'updated_at',
        ];
    }
}
