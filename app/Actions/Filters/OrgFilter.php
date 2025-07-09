<?php

namespace App\Actions\Filters;

use App\Models\Location;

class OrgFilter extends QueryFilter
{
    public function org_query($str = '')
    {
        if (empty($str)) {
            return true;
        }

        return $this->builder
            ->where('org_name', 'like', '%' . $str . '%')
            ->orWhere('contact_email', 'like', '%' . $str . '%')
            ->orWhere('contact_phone', 'like', '%' . $str . '%');
    }

    public function has_org_preference()
    {
        $org = authUserPrimaryOrg(true, ['preferences']);

        $preferences = $org ? $org->preferences()
            ->with([
                'prefValues',
                'prefValues.states',
                'prefValues.suburbs',
            ])
            ->whereIn('type', ['looking', 'both'])->get() : null;

        $builder = $this->builder;

        $builder->whereHas('preferences', function ($bq) use ($preferences) {
            foreach ($preferences as $preference) {
                $bq->whereNotNull('type')
                    ->whereIn('type', ['both', 'offer'])
                    ->orWhere(function ($cq) use ($preference) {
                        $cq->whereHas('prefValues', function ($dq) use ($preference) {
                            $dq->when($preference->type == 'both', function ($query) use ($preference) {
                                $whereLooking = $preference->prefValues()->where('type', 'looking')->first();
                                $query
                                    ->when($whereLooking->where == 'australia-wide', function ($query) {
                                        $query->where(function ($q) {
                                            $q->where('where', 'australia-wide');
                                        });
                                    })
                                    ->when($whereLooking->where == 'states'
                                        && $whereLooking->states
                                        && count($whereLooking->states), function ($query) use ($whereLooking) {
                                        $query->where('where', '=', 'states')
                                            ->whereHas('states', function ($stQuery) use ($whereLooking) {
                                                $stQuery->whereIn('state', $whereLooking->states->pluck('state')->toArray());
                                            });
                                    })
                                    ->when($whereLooking->where == 'suburbs'
                                        && $whereLooking->suburbs
                                        && count($whereLooking->suburbs), function ($query) use ($whereLooking) {
                                        $query->where('where', 'suburbs')
                                            ->whereHas('suburbs', function ($stQuery) use ($whereLooking) {
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
                                        $query->where(function ($q) use ($postcodes, $whereLooking) {
                                            $q->where('where', 'radius')
                                                ->whereIn('radius_location', $postcodes)
                                                ->whereBetween('radius', [0, $whereLooking->radius]);
                                        })->orWhere(function ($q) use ($postcodes, $whereLooking) {
                                            $q->where('where', 'radius')
                                                ->whereIn('radius_location', $postcodes)
                                                ->whereBetween('radius', [0, $whereLooking->radius]);
                                        });
                                    });
                            })
                                ->when($preference->type == 'looking', function ($query) use ($preference) {
                                    $where = $preference->prefValues;
                                    $query
                                        ->when($where->where == 'australia-wide', function ($query) {
                                            $query->where(function ($q) {
                                                $q->where('where', 'australia-wide');
                                            });
                                        })
                                        ->when($where->where == 'states'
                                            && $where->states
                                            && count($where->states), function ($query) use ($where) {
                                            $query->where('where', 'states')
                                                ->whereHas('states', function ($stQuery) use ($where) {
                                                    $stQuery->whereIn('state', $where->states->pluck('state')->toArray);
                                                });
                                        })
                                        ->when($where->where == 'suburbs'
                                            && $where->suburbs
                                            && count($where->suburbs), function ($query) use ($where) {
                                            $query->where('where', 'suburbs')
                                                ->whereHas('suburbs', function ($stQuery) use ($where) {
                                                    $stQuery->whereIn('suburb', $where->suburbs->pluck('suburb')->toArray);
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
                                            $query->where(function ($q) use ($postcodes, $where) {
                                                $q->where('where', 'radius')
                                                    ->whereIn('radius_location', $postcodes)
                                                    ->whereBetween('radius', [0, $where->radius]);
                                            })->orWhere(function ($q) use ($postcodes, $where) {
                                                $q->where('where', 'radius')
                                                    ->whereIn('radius_location', $postcodes)
                                                    ->whereBetween('radius', [0, $where->radius]);
                                            });
                                        });
                                });
                        });
                    });
            }
        });

        return $builder;
    }

    public function org_location($location)
    {
        return $this->builder->whereHas('preferences', function ($bq) use ($location) {
            $bq->whereNotNull('type')
                ->whereIn('type', ['both', 'offer'])
                ->whereHas('prefValues', function ($query) use ($location) {
                    $query
                        ->when($location == 'australia-wide', function ($query) {
                            $query->where('where', 'australia-wide');
                        })
                        ->when($location == 'states' && isset($this->request->org_states), function ($query) {
                            $query->where('where', 'states')
                                ->whereHas('states', function ($stQuery) {
                                    $stQuery->whereIn('state', explode(',', $this->request->org_states));
                                });
                        })
                        ->when($location == 'suburbs' && isset($this->request->org_suburbs), function ($query) {
                            $query->where('where', 'suburbs')
                                ->whereHas('suburbs', function ($stQuery) {
                                    $stQuery->whereIn('suburb', explode(',', $this->request->org_suburbs));
                                });
                        })
                        ->when($location == 'radius'
                            && isset($this->request->org_radius_location)
                            && isset($this->request->org_radius), function ($query) {
                            $location     = Location::find($this->request->org_location_id);
                            $locationLat  = $location->lat;
                            $locationLong = $location->long;
                            $locations    = Location::query()->withinDistanceOf($locationLat, $locationLong, $this->request->org_radius)
                                ->addDistanceFromField($locationLat, $locationLong, 'distance');
                            $postcodes    = $locations->pluck('postcode')->unique()->toArray();

                            $query->where('where', 'radius')
                                ->whereIn('radius_location', $postcodes)
                                ->whereBetween('radius', [0, $this->request->org_radius]);
                        });
                });
        });
    }

    public function org_fromDate($date = null)
    {
        if (empty($date)) {
            return true;
        }

        if ($this->request->filled('org_toDate')) {
            return $this->builder->whereBetween('created_at', [$date, $this->request->org_toDate]);
        }

        return $this->builder->whereDate('created_at', $date);
    }

    public function org_toDate($date = null)
    {
        if (empty($date)) {
            return true;
        }

        if ($this->request->filled('org_fromDate')) {
            return $this->builder->whereBetween('created_at', [$this->request->org_fromDate, $date]);
        }

        return $this->builder->whereDate('created_at', $date);
    }

}
