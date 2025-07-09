<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Organisation;

class NfpAdminService
{

    public function dashboard($category = null, $fromDate = null, $toDate = null): array
    {
        return [
            'getTotalRegistration' => $this->getTotalRegistration($category, $fromDate, $toDate),
            'getTotalNfpRegistration' => $this->getTotalNfpRegistration($category, $fromDate, $toDate),
            'getTotalIndiRegistration' => $this->getTotalIndiRegistration($category, $fromDate, $toDate),
            'getTotalCharityRegistration' => $this->getTotalCharityRegistration($category, $fromDate, $toDate),
        ];
    }

    private function getTotalRegistration($category = null, $fromDate = null, $toDate = null): int
    {
        $query = Organisation::query();

        $this->applyDateRangeCondition($query, $category, $fromDate, $toDate);

        return $query->count();
    }

    private function getTotalNfpRegistration($category = null, $fromDate = null, $toDate = null): int
    {
        $query = Organisation::where('client_type', 'nfp');

        $this->applyDateRangeCondition($query, $category, $fromDate, $toDate);

        return $query->count();
    }

    private function getTotalIndiRegistration($category = null, $fromDate = null, $toDate = null): int
    {
        $query = Organisation::where('client_type', 'individual');

        $this->applyDateRangeCondition($query, $category, $fromDate, $toDate);

        return $query->count();
    }

    private function getTotalCharityRegistration($category = null, $fromDate = null, $toDate = null): int
    {
        $query = Organisation::where('client_type', 'charity');

        $this->applyDateRangeCondition($query, $category, $fromDate, $toDate);

        return $query->count();
    }

    /**
     * Apply date range conditions to a query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $category
     * @param Carbon|null $fromDate
     * @param Carbon|null $toDate
     */
    private function applyDateRangeCondition($query, $category, $fromDate, $toDate)
    {
        $now = Carbon::now();

        switch ($category) {
            case 'this_year':
                $query->whereYear('created_at', $now->year);
                break;
            case 'last_year':
                $query->whereYear('created_at', $now->subYear()->year);
                break;
            case 'this_month':
                $query->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month);
                break;
            case 'last_month':
                $query->whereYear('created_at', $now->subMonth()->year)->whereMonth('created_at', $now->subMonth()->month);
                break;
            case 'this_week':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [$now->subWeek()->startOfWeek(), $now->subWeek()->endOfWeek()]);
                break;
        }

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }
}
