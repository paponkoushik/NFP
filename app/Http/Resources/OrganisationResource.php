<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationResource extends JsonResource
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
            'id'            => $this->id,
            'org_name'      => $this->org_name,
            'org_type'      => $this->org_type,
            'client_type'   => $this->client_type,
            'type'          => $this->client_type === "nfp" ? "Not For Profit" : ($this->client_type === "fp" ? "For Profit" : "Charity"),
            'abn'           => $this->abn,
            'acn'           => $this->acn,
            'website'       => $this->website,
            'address'       => $this->address,
            'city'          => $this->city,
            'state'         => $this->state,
            'postcode'      => $this->postcode,
            'logo'          => storageLink($this->logo, 'org'),
            'summary'       => $this->summary,
            'details'       => $this->details,
            'alias'         => $this->alias,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'status'        => $this->status,
            'created'       => dateFormat($this->created_at, "d F, Y"),
            'expired'       => $this->whenLoaded('subscription', fn() => isSubscriptionExpired($this->subscription->to) ? true : false),
            'subscription'  => $this->whenLoaded('subscription'),
            'org_locations' => $this->whenLoaded('primaryAddress'),
            'org_other_locations' => $this->whenLoaded('otherLocations'),
            'hasUsers'      => $this->whenLoaded('users', fn() => $this->users->count() > 0 ? true : false),
        ];
    }
}
