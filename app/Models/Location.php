<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Netsells\GeoScope\Traits\GeoScopeTrait;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Location extends Model
{
    use GeoScopeTrait;

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public static function getOptionsList(): EloquentCollection
    {
        return cache()
            ->rememberForever('locations', function() {
                return self::query()
                    ->select('id', 'address','state', 'locality', 'postcode', 'lat', 'long')
                    ->oldest('address')
                    ->get();
            });
    }

}
