<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Communication\CommsUserResource;
use Carbon\Carbon;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $is_seen = false;

        if ($this->comms->from_org_id === authUserOrgId()) {
            $is_seen = $this->comms->to_org_last_seen_at >= $this->created_at;
        } elseif ($this->comms->to_org_id === authUserOrgId()) {
            $is_seen = $this->comms->from_org_last_seen_at >= $this->created_at;
        }
        return [
            'id' => $this->id,
            'comms_id' => $this->comms_id,
            'comment' => $this->comment,
            'type' => $this->type,
            'is_seen' => $is_seen,
            'is_own' => ($this->user_id === auth()->user()->id) ? true : false,
            'time' => $this->created_at ? dateFormat($this->created_at, "h:i A") : null,
            'date' => $this->created_at ? dateFormat($this->created_at, "j F, Y") : null,
            'created_at' => $this->created_at ? $this->created_at : null,
            'user' => new CommsUserResource($this->whenLoaded('user')),
        ];
    }

    protected function getTime($date)
    {
        $currentDate = Carbon::now();
        $messageDate = Carbon::create($date);

//        if ($currentDate->diffInDays($messageDate) > 0) {
//            return dateFormat($date, "j F, Y h:i A");
//        }

        return dateFormat($date, "h:i A");
    }
}
