<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id'                   => $this->id,
            'name'                 => $this->name,
            'short_name'           => shortString($this->name),
            'code'                 => $this->code,
            'parent'               => $this->whenLoaded('parent', function () {
                return [
                    'id'         => $this->parent->id,
                    'name'       => $this->parent->name,
                    'short_name' => shortString($this->parent->name),
                    'code'       => $this->parent->code,
                ];
            }),
            'exclude_for'          => $this->exclude_for,
            'status'               => $this->status,
            'exclude_fields'       => $this->exclude_fields,
            'exclude_field_values' => $this->exclude_field_values,
            'custom_label'         => $this->custom_label,
            'created'              => dateFormat($this->created_at, 'D d M, Y'),
            'updated'              => dateFormat($this->updated_at, 'D d M, Y'),
        ];
    }
}
