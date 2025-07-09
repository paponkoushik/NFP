<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'organisation_id'  => $this->organisation_id,
            'order_no'         => $this->order_no,
            'order_amount'     => $this->order_amount,
            'gst'              => $this->gst,
            'cupon_used'       => $this->cupon_used,
            'has_discount'     => $this->has_discount,
            'discount_amount'  => $this->discount_amount,
            'total_amount'     => $this->total_amount,
            'transaction_code' => $this->transaction_code,
            'docs_count'       => $this->orderDetails->count(),
            'paid_at'          => $this->paid_at ? dateFormat($this->paid_at, 'M d, Y') : null,
            'created'          => $this->created_at ? dateFormat($this->created_at, 'M d, Y') : null,
            'updated'          => $this->updated_at ? dateFormat($this->updated_at, 'M d, Y') : null,
        ];
    }
}
