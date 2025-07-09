<?php

namespace App\Services;

use App\Enums\DateRange;
use App\Models\LegalRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LegalAdminService
{
    const WORKFLOW_STATUS_COMPLETED = 'Completed';
    const WORKFLOW_STATUS_IN_PROGRESS = 'In Progress';

    public function dashboard(
        DateRange|null $category = null,
        string|null $fromDate = null,
        string|null $toDate = null
    ): array
    {
        $currentWeekStartDate = Carbon::now()->startOfWeek();
        $currentWeekEndDate = Carbon::now()->endOfWeek();
        $currentMonthStartDate = Carbon::now()->startOfMonth();
        $currentMonthEndDate = Carbon::now()->endOfMonth();

        $totalRevenue = $this->getTotalRevenue();

        $getYearlyRevenueByMonth = $this->getYearlyRevenueByMonth();

        $totalRevenueThisWeek = $this->getTotalRevenueThisWeek($currentWeekStartDate, $currentWeekEndDate);

        $totalRevenueThisMonth = $this->getTotalRevenueThisMonth($currentMonthStartDate, $currentMonthEndDate);

        $getDailyRevenue = $this->getDailyRevenue();

        $latestLegalRequests = $this->getLatestLegalRequests();

        $getTotalRevenueByDayOfWeek = $this->getTotalRevenueByDayOfWeek($currentWeekStartDate, $currentWeekEndDate);

        $getTotalReqAndProReq =  $this->getTotalReqAndProReq();

        $getTotalReqAndProByMonth = $this->getTotalReqAndProByMonth();

        $totalCompleted = $this->totalCompleted();

        $performance = $this->performance();

        $getLawyerRatingsData = $this->getLawyerRatingsData($category, $fromDate, $toDate);

        $data = [
            'totalRevenue' => $totalRevenue,
            'getYearlyRevenueByMonth' => $getYearlyRevenueByMonth,
            'totalRevenueThisWeek' => $totalRevenueThisWeek,
            'totalRevenueThisMonth' => $totalRevenueThisMonth,
            'getDailyRevenue' => $getDailyRevenue,
            'getTotalRevenueByDayOfWeek' => $getTotalRevenueByDayOfWeek,
            //'latestLegalRequests' => $latestLegalRequests,
            'getTotalReqAndProReq' => $getTotalReqAndProReq,
            'getTotalReqAndProByMonth' => $getTotalReqAndProByMonth,
            'totalCompleted' => $totalCompleted,
            'performance' => $performance,
            'getLawyerRatingsData' => $getLawyerRatingsData,
        ];

        return $data;
    }

    private function getRevenueQuery()
    {
        return LegalRequest::where('workflow_status', self::WORKFLOW_STATUS_COMPLETED);
    }


    /**
     * Get the total revenue for completed legal requests.
     *
     * @return float
     */
    private function getTotalRevenue(): float
    {
        return $this->getRevenueQuery()->sum('billed_amount');
    }

    private function getTotalRevenueThisWeek($startDate, $endDate): float
    {
        return $this->getRevenueQuery()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('billed_amount');
    }

    private function getTotalReqAndProReq()
    {
        $counts = LegalRequest::selectRaw('COUNT(*) as total_count, SUM(CASE WHEN workflow_status = "In Progress" THEN 1 ELSE 0 END) as processed_count')->first();

        $totalRowCount = $counts->total_count;
        $processedRowCount = $counts->processed_count;

        $data = $totalRowCount . '|' . $processedRowCount;
        return $data;
    }


    private function getTotalReqAndProByMonth()
    {
        $counts = DB::table('legal_requests')
            ->selectRaw('SUBSTRING(DATE_FORMAT(created_at, "%b"), 1, 3) as month')
            ->selectRaw('COUNT(*) as total_count')
            ->selectRaw('SUM(CASE WHEN workflow_status = "In Progress" THEN 1 ELSE 0 END) as in_progress_count')
            ->whereNotNull('created_at')
            ->whereNotNull('workflow_status')
            ->groupBy(DB::raw('SUBSTRING(DATE_FORMAT(created_at, "%b"), 1, 3)'))
            ->orderBy(DB::raw('MIN(created_at)'), 'desc')
            ->get()
            ->keyBy('month');

        return $counts;
    }

    private function getTotalRevenueByDayOfWeek($startDate, $endDate)
    {
        $revenueData = LegalRequest::selectRaw('LEFT(DAYNAME(created_at), 1) as first_letter, SUM(billed_amount) as revenue')
            ->where('workflow_status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('first_letter')
            ->get();

        $firstLetterWithTotalRevenue = [];
        foreach ($revenueData as $item) {
            $firstLetterWithTotalRevenue[$item->first_letter] = $item->revenue;
        }

        return $firstLetterWithTotalRevenue;
    }

    private function totalCompleted()
    {

        $currentMonth = Carbon::now()->format('Y-m');
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');

        $currentMonthCount = LegalRequest::where('workflow_status', 'Completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();


        $previousMonthCount = LegalRequest::where('workflow_status', 'Completed')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        if ($previousMonthCount > 0) {
            $percentageChange = (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100;
        } else {
            $percentageChange = 0;
        }
        $percentageChangeFormatted = number_format($percentageChange, 2);

        return [
            'currentMonthCount' => $currentMonthCount,
            'percentageChange' => $percentageChangeFormatted,
        ];
    }

    private function performance()
    {
        $totalRowCount = LegalRequest::count();

        $completedRowCount = LegalRequest::where('workflow_status', 'Completed')->count();

        if ($totalRowCount > 0) {
            $percentageCompleted = ($completedRowCount / $totalRowCount) * 100;
        } else {
            $percentageCompleted = 0; // Handle the case where there are no total rows.
        }
        $percentageCompletedFormatted = number_format($percentageCompleted, 2);
        return $percentageCompletedFormatted;
    }


    private function getTotalRevenueThisMonth($startDate, $endDate): float
    {
        return LegalRequest::where('workflow_status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('billed_amount');
    }

    private function getDailyRevenue(): array
    {
        $year = now()->year;
        $month = now()->month;

        $revenueData = LegalRequest::selectRaw('DAY(created_at) as day, SUM(billed_amount) as revenue')
            ->where('workflow_status', 'Completed')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $result = [];

        foreach ($revenueData as $item) {
            $result[$item->day] = $item->revenue;
        }

        return $result;
    }

    private function getYearlyRevenueByMonth(): array
    {
        $year = now()->year;

        $monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
        ];
        $result = [];

        foreach ($monthNames as $monthName) {
            $totalRevenue = LegalRequest::where('workflow_status', 'Completed')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', date('m', strtotime($monthName)))
                ->sum('billed_amount');

            if ($totalRevenue > 0) {
                $result[$monthName] = $totalRevenue;
            }
        }

        return $result;
    }

    private function getLatestLegalRequests(): array
    {
        return LegalRequest::where('workflow_status', 'New')
            ->with('listing:title', 'requestedUser', 'assignedTo')
            ->get([
                'request_no',
                'assigned_to',
                'requested_user_id',
                'listing_id',
                'created_at',
            ])
            ->map(function ($record) {
                return [
                    'request_no' => $record->request_no,
                    'requested_user_id' => optional($record->requestedUser)->first_name,
                    'assigned_to' => optional($record->assignedTo)->first_name,
                    'listing_id' => optional($record->listing)->title,
                    'created_at' => Carbon::parse($record->created_at)->diffForHumans(),
                ];
            })->toArray();
    }

    public function getLawyerRatingsData(
        DateRange|null $category = null,
        string|null $fromDate = null,
        string|null $toDate = null
    ): array
    {
        $query = LegalRequest::select(
            'assigned_to',
            DB::raw('SUM(CASE WHEN workflow_status = "Completed" THEN 1 ELSE 0 END) as completed_count'),
            DB::raw('SUM(CASE WHEN workflow_status = "In Progress" THEN 1 ELSE 0 END) as in_progress_count')
        )->whereNotNull('assigned_to');

        $this->applyDateRangeCondition($query, $category, $fromDate, $toDate);

        $results = $query->groupBy('assigned_to')
            ->with('assignedTo')
            ->get()
            ->mapWithKeys(function ($record) {
                return [
                    $record->assignedTo->first_name => [
                        'assigned_to' => optional($record->assignedTo)->first_name,
                        'completed_count' => $record->completed_count,
                        'in_progress_count' => $record->in_progress_count,
                    ],
                ];
            })
            ->toArray();

        return $results;
    }

    private function applyDateRangeCondition(
        Builder $query,
        DateRange|null $category = null,
        string|null $fromDate = null,
        string|null $toDate = null
    ): void
    {
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($category) {
            if ($category === DateRange::ThisYear->value) {
                $query->whereYear('created_at', now()->year);
            } elseif ($category === DateRange::LastYear->value) {
                $query->whereYear('created_at', now()->subYear()->year);
            } elseif ($category === DateRange::ThisMonth->value) {
                $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
            } elseif ($category === DateRange::LastMonth->value) {
                $query->whereYear('created_at', now()->subMonth()->year)->whereMonth('created_at', now()->subMonth()->month);
            } elseif ($category === DateRange::ThisWeek->value) {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($category === DateRange::LastWeek->value) {
                $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
            }
        }
    }
}
