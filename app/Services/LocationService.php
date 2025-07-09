<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    protected $model;

    protected $locations;

    public function __construct(Location $location)
    {
        $this->model = $location;
        $this->cacheLocation();
    }

    public function cacheLocation(): LocationService
    {
        $this->locations = $this->model->getOptionsList();

        return $this;
    }

    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function getStates(): Collection
    {
        return cache()
            ->rememberForever('states',
                fn () => cache()->get('locations')->unique('state')
            );
    }

    public function getCities(string $state): Collection
    {
        return cache()
            ->get('locations')
            ->where('state', $state);
    }

    public function getPostcode(string $city): Collection
    {
        return cache()
            ->get('locations')
            ->where('locality', $city);
    }

    public function getCityState(string $postcode): Collection
    {
        return cache()
            ->get('locations')
            ->where('postcode', $postcode);
    }
}
