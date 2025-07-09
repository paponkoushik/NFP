<?php

namespace App\Http\Resources\Listing;

use App\Http\Resources\ListingPreferenceResource;
use App\Http\Resources\Offer\OfferListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Resources\OrganisationResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $not_seen_count = $this->whenLoaded('offers', function () {
            return $this->offers->reject(function (object $item) {
                $item->is_seen = $item->communication->to_org_last_seen_at >= $item->created_at;
                return $item->is_seen;
            })->count();
        });

        return [
            'id'                    => $this->id,
            'category_id'           => $this->category_id,
            'location_id'           => $this->location_id,
            'organisation_id'       => $this->organisation_id,
            'is_own'                => $this->organisation_id == authUserOrgId(),
            'title'                 => $this->title,
            'type'                  => $this->type,
            'description'           => $this->description,
            'clean_description'     => cleanHtmlFromText($this->description),
            'images'                => $this->getImagesPath($this->images),
            'originalImages'        => $this->images,
            'price_type'            => $this->price_type,
            'price'                 => $this->price,
            'preferences'            => new ListingPreferenceResource($this->whenLoaded('preference')),
            'city'                  => $this->city,
            'state'                 => $this->state,
            'postcode'              => $this->postcode,
            'address'               => $this->address,
            'visits'                => $this->visits,
            'is_anonymous'          => $this->is_anonymous,
            'is_archived'           => $this->is_archived,
            'archived_at'           => $this->archived_at ? dateFormat($this->archived_at, 'd M, Y') : null,
            'status'                => $this->status,
            'created_day'           => dateFormat($this->created_at, 'd'),
            'created_month'         => dateFormat($this->created_at, 'M'),
            'created_at'            => dateFormat($this->created_at, 'd M, Y'),
            'deadline'              => Carbon::parse($this->created_at)->addDays(rand(10, 29))->format('d M, Y'),
            'updated_at'            => dateFormat($this->updated_at, 'd M, Y'),
            'category'              => $this->whenLoaded('category'),
            'location'              => $this->whenLoaded('location'),
            'organisation'          => new OrganisationResource($this->whenLoaded('organisation')),
            'author'                => $this->whenLoaded('createdBy'),
            'offers'                => OfferListResource::collection($this->whenLoaded('offers')),
            'offers_not_seen_count' => $not_seen_count,
        ];
    }

    private function getImagesPath($images)
    {
        if (is_array($images) && count($images) > 0) {
            $paths = [];
            foreach ($images as $image) {
                $paths[] = Storage::disk('public')->url($image);
            }

            return $paths;
        }

        return [
            url('/assets/img/post-preview-' . rand(1, 6) . '.png'),
            url('/assets/img/post-preview-' . rand(1, 6) . '.png'),
            url('/assets/img/post-preview-' . rand(1, 6) . '.png'),
            url('/assets/img/post-preview-' . rand(1, 6) . '.png')
        ];
    }
}
