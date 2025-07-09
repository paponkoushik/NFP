<?php

namespace App\Actions\Filters;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListingFilter extends QueryFilter
{
    /**
     * The order field associated with the filter.
     *
     * @var string
     */
    protected $orderField;

    /**
     * Filter listings based on search columns.
     *
     * @param String $str
     * @return Query Builder
     */
    public function query($str = '')
    {
        if (empty($str)) {
            return true;
        }
        $searchColumns = "title, description, COALESCE(address, '')";

        return $this->builder->whereRaw("(CONCAT($searchColumns) LIKE ?)", ['%' . $str . '%']);
    }

    /**
     * Filter listings based on a listing author.
     *
     * @param Char $userId
     * @return Query Builder
     */
    public function author($userId)
    {
        $user = User::query()->find($userId);
        $user->organisationUser()->first()->organisation_id;
//        dd($user->organisationUser()->first()->organisation_id);
        return $this->builder->where('organisation_id', $user->organisationUser()->first()->organisation_id);
    }

    /**
     * Filter listings based on a given status.
     *
     * @param String $status
     * @return Query Builder
     */
    public function status($status)
    {
        return $this->builder->whereStatus($status);
    }

    /**
     * Filter listings based on a given category.
     *
     * @param Char $categoryId
     * @return Query Builder
     */
    public function category($categoryId)
    {
        return $this->builder->whereIn('category_id', explode(',', $this->request->categories));
    }

    public function categories($categories)
    {
        return $this->builder->whereIn('category_id', explode(',', $categories))
            ->orWhereHas('category', function ($query) use ($categories) {
                $query->whereIn('parent_id', explode(',', $categories))
                    ->orWhereHas('parent', function ($query) use ($categories) {
                        $query->whereIn('parent_id', explode(',', $categories));
                    });
            });
    }

    /**
     * Filter listings based on a given location.
     *
     * @param string $location
     * @return Query Builder
     */
    public function location($location)
    {
        return $this->builder
            ->whereHas('preference', function ($prefQuery) use ($location) {
                $prefQuery
                    ->when($location == 'australia-wide', function ($query) {
                        $query->where('where', 'australia-wide');
                    })
                    ->when($location == 'states' && isset($this->request->states), function ($query) {
                        $query->where('where', 'states')
                            ->whereHas('stateList', function ($stQuery) {
                                $stQuery->whereIn('state', explode(',', $this->request->states));
                            });
                    })
                    ->when($location == 'suburbs' && isset($this->request->suburbs), function ($query) {
                        $query->where('where', 'suburbs')
                            ->whereHas('suburbList', function ($stQuery) {
                                $stQuery->whereIn('suburb', explode(',', $this->request->suburbs));
                            });
                    })
                    ->when($location == 'radius'
                        && isset($this->request->radius_location)
                        && isset($this->request->radius), function ($query) {
                        $location     = Location::find($this->request->location_id);
                        $locationLat  = $location->lat;
                        $locationLong = $location->long;
                        $locations    = Location::query()->withinDistanceOf($locationLat, $locationLong, $this->request->radius)
                            ->addDistanceFromField($locationLat, $locationLong, 'distance');
                        $postcodes    = $locations->pluck('postcode')->unique()->toArray();

                        // check if query is in postcodes by json column
                        $query->where('where', 'radius')
                            ->whereIn('radius_location', $postcodes)
                            ->whereBetween('radius', [0, $this->request->radius]);
                    });
            });
    }


    /**
     * Filter listings based on a auth user preference.
     *
     * @param string $pref
     * @return Query Builder
     */
    public function has_my_preference($pref)
    {
        $org            = authUserPrimaryOrg(true, [
            'preferences',
            'preferences.category',
            'preferences.category.parent',
            'preferences.category.parent.parent'
        ]);
        $preferences    = $org ? $org->preferences()
            ->with([
                'prefValues',
                'prefValues.states',
                'prefValues.suburbs',
            ])->where('type', 'looking')
            ->orWhere('type', 'both')->get() : null;
        $orgCategoryIds = authUserOrgCategoryIds();

        $builder = $this->builder;

        $builder->whereIn('category_id', $orgCategoryIds);
        foreach ($preferences as $preference) {
            $builder->orWhere(function ($query) use ($preference) {
                $query->whereHas('preference', function ($prefQuery) use ($preference) {
                    $prefQuery
                        ->when($preference->type == 'both', function ($query) use ($preference) {
                            $whereLooking = $preference->prefValues()->where('type', 'looking')->first();
                            $query
                                ->when($whereLooking->where == 'australia-wide', function ($query) {
                                    $query->where('where', 'australia-wide');
                                })
                                ->when($whereLooking->where == 'states'
                                    && $whereLooking->states
                                    && count($whereLooking->states), function ($query) use ($whereLooking) {
                                    $query->where('where', 'states')
                                        ->whereHas('stateList', function ($stQuery) use ($whereLooking) {
                                            $stQuery->whereIn('state', $whereLooking->states->pluck('state')->toArray());
                                        });
                                })
                                ->when($whereLooking->where == 'suburbs'
                                    && $whereLooking->suburbs
                                    && count($whereLooking->suburbs), function ($query) use ($whereLooking) {
                                    $query->where('where', 'suburbs')
                                        ->whereHas('suburbList', function ($stQuery) use ($whereLooking) {
                                            $stQuery->whereIn('suburb', $whereLooking->suburbs->pluck('suburb')->toArray());
                                        });
                                })
                                ->when($whereLooking->where == 'radius'
                                    && $whereLooking->radius_location
                                    && $whereLooking->radius, function ($query) use ($whereLooking) {
                                    $location     = Location::find($whereLooking->location_id);
                                    $locationLat  = $location->lat;
                                    $locationLong = $location->long;
                                    $locations    = Location::query()
                                        ->withinDistanceOf($locationLat, $locationLong, $whereLooking->radius)
                                        ->addDistanceFromField($locationLat, $locationLong, 'distance');
                                    $postcodes    = $locations->pluck('postcode')->unique()->toArray();

                                    // check if query is in postcodes by json column
                                    $query->where('where', 'radius')
                                        ->whereIn('radius_location', $postcodes)
                                        ->whereBetween('radius', [0, $whereLooking->radius]);
                                });
                        })
                        ->when($preference->type == 'looking', function ($query) use ($preference) {
                            $where = $preference->prefValues;
                            $query
                                ->when($where->where == 'australia-wide', function ($query) {
                                    $query->where('where', 'australia-wide');
                                })
                                ->when($where->where == 'states'
                                    && $where->states
                                    && count($where->states), function ($query) use ($where) {
                                    $query->where('where', 'states')
                                        ->whereHas('stateList', function ($stQuery) use ($where) {
                                            $stQuery->whereIn('state', $where->states->pluck('state')->toArray());
                                        });
                                })
                                ->when($where->where == 'suburbs'
                                    && $where->suburbs
                                    && count($where->suburbs), function ($query) use ($where) {
                                    $query->where('where', 'suburbs')
                                        ->whereHas('suburbList', function ($stQuery) use ($where) {
                                            $stQuery->whereIn('suburb', $where->suburbs->pluck('suburb')->toArray());
                                        });
                                })
                                ->when($where->where == 'radius'
                                    && $where->radius_location
                                    && $where->radius, function ($query) use ($where) {
                                    $location     = Location::find($where->location_id);
                                    $locationLat  = $location->lat;
                                    $locationLong = $location->long;
                                    $locations    = Location::query()
                                        ->withinDistanceOf($locationLat, $locationLong, $where->radius)
                                        ->addDistanceFromField($locationLat, $locationLong, 'distance');
                                    $postcodes    = $locations->pluck('postcode')->unique()->toArray();

                                    // check if query is in postcodes by json column
                                    $query->where('where', 'radius')
                                        ->whereIn('radius_location', $postcodes)
                                        ->whereBetween('radius', [0, $where->radius]);
                                });
                        });
                });
            });
        }

        return $builder;
    }

    /**
     * Filter matches based on given date.
     *
     * @param String $status
     * @return Query Builder
     */
    public function fromDate($date = null)
    {
        if (empty($date)) {
            return true;
        }

        if ($this->request->filled('toDate')) {
            return $this->builder->whereBetween('created_at', [$date, $this->request->toDate]);
        }

        return $this->builder->whereDate('created_at', $date);
    }

    /**
     * Filter matches based on given date.
     *
     * @param String $status
     * @return Query Builder
     */
    public function toDate($date = null)
    {
        if (empty($date)) {
            return true;
        }

        if ($this->request->filled('fromDate')) {
            return $this->builder->whereBetween('created_at', [$this->request->fromDate, $date]);
        }

        return $this->builder->whereDate('created_at', $date);
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
            'industry_id', 'org_name', 'org_type', 'contact_email', 'address', 'city', 'status'
        ];
    }
}
