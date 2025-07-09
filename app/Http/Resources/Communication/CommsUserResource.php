<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Resources\Json\JsonResource;

class CommsUserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => ucFirst($this->first_name. " " .$this->last_name),
            'short_name' => shortString($this->first_name. " " .$this->last_name),
            'avatar' => $this->avatar ? url($this->avatar) : null,
            'last_login_at' => $this->last_login_at ? lastActiveTime($this->last_login_at) : null,
            'is_online' => $this->is_online
        ];
    }
}
