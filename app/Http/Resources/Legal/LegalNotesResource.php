<?php

namespace App\Http\Resources\Legal;

use App\Models\Workflow;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalNotesResource extends JsonResource
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
            'stage' => $this->stage,
            'step' => $this->step,
            'note' => $this->note,
            'when' => dateFormat($this->created_at, 'd/m/Y'),
            'time' => dateFormat($this->created_at, 'h:i A'),
            'badgeClass' => Workflow::getBadgeClass($this->step, $this->stage),
            'who' => new LegalUserResource($this->whenLoaded('createdBy'))
        ];
    }
}
