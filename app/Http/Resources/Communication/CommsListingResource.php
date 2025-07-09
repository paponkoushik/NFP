<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Communication\CommsResource;

class CommsListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $latestMessageTime = $this->whenLoaded('communications', function () {
            if (! $this->communications->isEmpty()) {
                return $this->communications()->with('latestMessage')->first();
            }

            return null;
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at ? dateFormat($this->created_at, 'j F, Y') : null,
            'latest_message_at' => $latestMessageTime?->latestMessage?->created_at,
            'communications' => CommsResource::collection($this->whenLoaded('communications'))
        ];
    }
}
