<?php

namespace App\Http\Controllers\Location;

use App\Models\Location;
use App\Services\LocationService;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class LocationController extends Controller
{
    protected $service;

    public function __construct(LocationService $locationService)
    {
        $this->service = $locationService;
    }

    public function getAllLocations(): Collection
    {
        return $this->service->getLocations();
    }

    public function getStates(): JsonResponse
    {
        return response()->json($this->service->getStates());
    }

    public function getCities(string $state): JsonResponse
    {
        return response()->json($this->service->getCities($state));
    }

    public function getPostcode(string $city): JsonResponse
    {
        return response()->json($this->service->getPostcode($city)->first());
    }

    public function getCityState(string $postcode): JsonResponse
    {
        return response()->json($this->service->getCityState($postcode)->first());
    }

    /**
     * Display a listing of the collections.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByCityPostcode(Request $request): JsonResponse
    {
        $query = $request->get('search');

        if (!$query) {
            return response()->json(null);
        }

        $locations = Location::query()
            ->select('id', 'locality', 'state', 'postcode', 'lat', 'long')
            ->where('postcode', 'LIKE', '%' . $query . '%')
            ->orWhere('locality', 'LIKE', '%' . $query . '%')
            ->take(10)->get();

        return response()->json($locations);
    }

    public function getPlaceId(Request $request): JsonResponse
    {
        $latitude = $request->input('lat');
        $longitude = $request->input('long');
        $apiKey = config()->get('app.google_map_api_key');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";

        $client = new Client();

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody());

            if ($data->status === 'OK') {
                $placeId = $data->results[0]->place_id;
                return response()->json(['place_id' => $placeId]);
            } else {
                return response()->json(['error' => 'Place ID not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'API request failed'], 500);
        }
    }

}
