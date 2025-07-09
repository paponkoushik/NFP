<?php

namespace App\Http\Resources\Offer;

use App\Http\Resources\Listing\ListingResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OfferListResource extends JsonResource
{
    public function toArray($request): array
    {
        $isOfferSeen = $this->whenLoaded('communication', function () {
            return $this->communication->to_org_last_seen_at >= $this->created_at;
        });

        return [
            'id' => $this->id,
            'offer_amount' => $this->offer_amount,
            'status' => $this->status,
            'offered_date' => dateFormat($this->offered_at, 'j F, Y'),
            'offered_time' => dateFormat($this->offered_at, 'h:i A'),
            'offer_details' => $this->offer_details,
            'offer_note' => $this->note,
            'is_offer_seen' => $isOfferSeen,
            'offered_accepted_date' => $this->offered_accepted_at ? dateFormat($this->offered_accepted_at, 'j F, Y'): null,
            'offered_accepted_time' => $this->offered_accepted_at ? dateFormat($this->offered_accepted_at, 'h:i A'): null,
            'price_type' => $this->price_type,
            'is_fixed_price' => $this->is_fixed_price,
            'list'=> $this->whenLoaded('list', function () {
                return [
                    'id' => $this->list->id,
                    'title' => $this->list->title,
                    'is_anonymous' => $this->list->is_anonymous,
                    'created_at_date' => $this->list->created_at ? dateFormat($this->list->created_at, 'j F, Y'): null,
                    'created_at_time' => $this->list->created_at ? dateFormat($this->list->created_at, 'h:i A'): null,
                ];
            }),
            'comms' => $this->whenLoaded('communication', function () {
                return [
                    'send_anonymously' => $this->communication->from_org_anonymous,
                    'from_org_id' => $this->communication->from_org_id,
                    'to_org_id' => $this->communication->to_org_id,
                    'id' => $this->communication->id
                ];
            }),
        ];
    }
}
