<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Resources\Json\JsonResource;

class CommsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $latestMessageTime = $this->whenLoaded('messages', function () {
            return $this->latestMessage()->first()->created_at;
        });

        return [
            'id' => $this->id,
            'listing_id' => $this->listing_id,
            'from_org_id' => $this->from_org_id,
            'to_org_id' => $this->to_org_id,
            'is_offered' => $this->is_offered,
            'offered_amount' => $this->offered_amount,
            'to_org_anonymous' => $this->to_org_anonymous,
            'from_org_anonymous' => $this->from_org_anonymous,
            'offer_status' => $this->offer_status,
            'own_offer' => authUserOrgId() === $this->to_org_id ? false : true,
            'is_anonymous' => authUserOrgId() === $this->to_org_id ? $this->from_org_anonymous : $this->to_org_anonymous,
            'created_at' => $this->created_at ? dateFormat($this->created_at, 'j F, Y') : null,
            'latest_message_at' => $latestMessageTime,
            'listing' => $this->whenLoaded('listing', function() {
                return [
                    'id' => $this->listing->id,
                    'title' => $this->listing->title,
                    'created_at' => $this->listing->created_at ? dateFormat($this->listing->created_at, 'j F, Y') : null,
                ];
            }),
            'organisation' => $this->whenLoaded('senderOrg', function() {
                return [
                    'id' => $this->senderOrg->id,
                    'name' => $this->senderOrg->org_name,
                    'anonymous_name' => $this->senderOrg->alias,
                    'anonymous_short_name' => shortString($this->senderOrg->alias),
                    'user' => new CommsUserResource($this->senderOrg->users[0]),
                ];
            }),
            'status' => $this->status,
        ];
    }
}
