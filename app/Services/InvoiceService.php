<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Document;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DocumentResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvoiceService
{
    public function getInvoiceDetails($id)
    {
        $order = Order::with('orderDetails')->find($id);
        if (!$order) {
            return null;
        }
        $documentIds = $order->orderDetails->pluck('document_id');
        $documentInfo = DocumentResource::collection(Document::whereIn('id', $documentIds)->get());
        $userInfo = User::with('organisationUser.organisation')->find(Auth::user()->id);
        $response = [
            'order' => $order,
            'documentInfo' => $documentInfo,
            'userInfo' => $userInfo,
        ];

        return $response;
    }
}
