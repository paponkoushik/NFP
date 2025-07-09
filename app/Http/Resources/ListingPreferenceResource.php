<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingPreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'listing_id'      => $this->listing_id,
            'where'           => $this->where,
            'states'          => $this->stateList && $this->stateList->count() ? $this->stateList->pluck('state')->toArray() : [],
            'suburbs'         => $this->suburbList && $this->suburbList->count() ? $this->suburbList->pluck('suburb')->toArray() : [],
            'radius'          => $this->radius,
            'radius_location' => $this->radius_location,
            'when'            => $this->when,
            'date'            => $this->date,
            'from_date'       => $this->from_date,
            'to_date'         => $this->to_date,
            'cost'            => $this->cost,
            'amount'          => $this->amount,
            'from_amount'     => $this->from_amount,
            'to_amount'       => $this->to_amount,
            'frequency'       => $this->frequency,
            'lat'             => $this->lat,
            'long'            => $this->long,
            'location_id'     => $this->location_id,
        ];
    }
}
