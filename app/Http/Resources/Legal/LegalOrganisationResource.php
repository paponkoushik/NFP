<?php

namespace App\Http\Resources\Legal;

use Illuminate\Http\Resources\Json\JsonResource;

class LegalOrganisationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->org_name,
            'type' => $this->org_type,
            'url' => route('org.details', $this->id),
            'img' => 'https://cdn-icons-png.flaticon.com/128/5968/5968705.png',
            'owner' => new LegalUserResource($this->whenLoaded('createdBy'))
        ];
    }
}
