<?php

namespace App\Http\Resources\Legal;

use Illuminate\Http\Resources\Json\JsonResource;

class LegalUserResource extends JsonResource
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
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar ? asset($this->avatar) : asset('/assets/img/avatar.png'),
        ];
    }
}
