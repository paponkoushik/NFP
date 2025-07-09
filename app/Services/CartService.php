<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Document;
use App\Models\OrderDetail;
use App\Mail\OrderConfirmMailable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\DocumentResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartService
{

    private $documentModel;
    private $orderModel;
    private $orderDetailModel;

    public function __construct(Document $document, Order $order, OrderDetail $orderDetail)
    {
        $this->documentModel = $document;
        $this->orderModel = $order;
        $this->orderDetailModel = $orderDetail;
    }

    /**
     * Get cart items based on session data.
     *
     * @return Collection
     */
    public function cartItems()
    {
        $documentIds = $this->getSessionData();
        return $this->idToDocumentsDetails($documentIds);
    }

    /**
     * Retrieve document IDs from the session.
     *
     * @return array
     */
    private function getSessionData(): array
    {
        return session('cart_documents') ?? [];
    }


    public function removeItemFromSession($id)
    {
        $documentIds = $this->getSessionData();
        $updatedDocumentIds = array_values(array_diff($documentIds, [$id]));
        session(['cart_documents' => $updatedDocumentIds]);
        return $this->cartItems();
    }

    /**
     * Get document details for the given IDs.
     *
     * @param  array  $cartDocumentIds
     * @return Collection
     */
    private function idToDocumentsDetails(array $cartDocumentIds): ResourceCollection
    {
        return DocumentResource::collection(
            $this->documentModel->loadRelation()->whereIn('id', $cartDocumentIds)->get()
        );
    }


    public function saveCartItems()
    {
        $documentIds = $this->getSessionData();

        $orgUser = User::with('organisationUser')->find(Auth::user()->id);
        $totalPrice = $this->cartItems()->sum('price');

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = $orgUser->id;
            $order->organisation_id = $orgUser->organisationUser->organisation_id;
            $order->order_no = rand(100000, 999999);
            $order->order_amount = $totalPrice;
            $order->has_discount = 0;
            $order->total_amount = $totalPrice;
            $order->paid_at = Carbon::now();
            $order->save();

            $orderDetails = $this->cartItems()->map(function ($cartItem) use ($order) {
                return [
                    'order_id' => $order->id,
                    'document_id' => $cartItem->id,
                    'document_price' => $cartItem->price,
                ];
            });

            $this->orderDetailModel::insert($orderDetails->toArray());

            DB::commit();
            session()->forget('cart_documents');
            Mail::to($orgUser->email)->send(new OrderConfirmMailable($orderDetails));
            return $this->orderDetails();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function orderDetails()
    {
        $documentIds = $this->orderModel->where('user_id', Auth::user()->id)->first();
        $documentIds = $this->orderDetailModel->where('order_id', $documentIds->id)->pluck('document_id')->toArray();
        return $this->idToDocumentsDetails($documentIds);
    }

    public function getUserOrderInfo()
    {
      return $userWithLatestOrder = User::join('orders', 'users.id', '=', 'orders.user_id')
      ->select('users.email', 'orders.order_no', DB::raw("DATE_FORMAT(orders.created_at, '%d/%m/%Y %h:%i%p') as formatted_created_at"))
      ->where('users.id', Auth::user()->id)
      ->latest('orders.created_at')
      ->first();

    }
}
