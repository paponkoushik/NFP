<?php

namespace App\Http\Resources;

use App\Http\Resources\DocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'organisation_id' => $this->organisation_id,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'created' => $this->created_at ? dateFormat($this->created_at, 'M d, Y') : null,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
            'childs' => CollectionResource::collection($this->whenLoaded('childs')),
        ];
    }
}
