<?php

namespace App\Http\Resources\Legal;

use Illuminate\Http\Resources\Json\JsonResource;

class LegalListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parentCategory = optional($this->category)->parent_category_name;

        return [
            'title' => $this->title,
            'type' => optional($this->category)->name . ($parentCategory ? ' > ' . $parentCategory : ''),
            'img' => 'https://cdn-icons-png.flaticon.com/128/5968/5968705.png',
//            'price' => $this->price,
            'url' => route('posts.show', ['post' => $this->id]),
            'createdBy' => $this->whenLoaded('createdBy')
        ];
    }
}
