<?php

namespace App\Http\Resources\Org;

use Illuminate\Http\Resources\Json\JsonResource;

class OrgListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'org_name'        => $this->org_name,
            'org_type'        => $this->org_type,
            'client_type'     => $this->client_type,
            'type'            => $this->client_type === "nfp" ? "Not For Profit" : ($this->client_type === "fp" ? "For Profit" : "Charity"),
            'logo'            => storageLink($this->logo, 'org'),
            'created_at'      => dateFormat($this->created_at, "d F, Y"),
            'contact_phone'   => $this->contact_phone,
            'contact_email'   => $this->contact_email,
            'other_locations' => LocationResource::collection($this->whenLoaded('otherLocations')),
            'categories'      => CategoryResource::collection($this->whenLoaded('categories'))

            //            'categories' => $this->whenLoaded('categories', function () {
            //                return [
            //                    'id' => $this->categories->id,
            //                    'name' => $this->categories->name,
            //                    'status' => $this->categories->status,
            //
            //                ];
            //            })

        ];
    }
}
