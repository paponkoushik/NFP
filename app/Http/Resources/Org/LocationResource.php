<?php

namespace App\Http\Resources\Org;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'address' => $this->address,
        ];
    }
}
