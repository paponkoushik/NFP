<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'avatar' => $this->avatar ? url($this->avatar) : null,
            'is_online' => $this->is_online,
            'status' => $this->status,
            'stripe_id' => $this->stripe_id,
            'pm_type' => $this->pm_type,
            'pm_last_four' => $this->pm_last_four,
            'trial_ends_at' => $this->trial_ends_at,
            'created' => dateFormat($this->created_at, 'D d M, Y'),
            'updated' => dateFormat($this->updated_at, 'D d M, Y'),
        ];
    }
}
