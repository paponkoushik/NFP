<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\CollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'path' => $this->path,
            'type' => $this->file_type,
            'summary' => $this->summary,
            'price' => round($this->price),
            'is_free' => $this->is_free,
            'download' => $this->total_download,
            'purchased' => $this->total_purchased,
            'organisation_id' => $this->organisation_id,
            'status' => $this->status,
            'created' => $this->created_at ? dateFormat($this->created_at, 'M d, Y') : null,
            'updated' => $this->updated_at ? dateFormat($this->updated_at, 'M d, Y') : null,
            'tags' => $this->whenLoaded('documentTags', fn() => $this->documentTags->pluck('name')->all()),
            'enc_id' => Crypt::encrypt($this->id),
            'documentCollections' => $this->whenLoaded('documentCollections', fn() => $this->documentCollections->pluck('collection_id')->all()),
            'collections' => CollectionResource::collection($this->whenLoaded('collections')),
        ];
    }
}
