<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Models\Comms;
use App\Models\Offer;
use App\Services\OfferServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    protected $services;

    public function __construct(OfferServices $services)
    {
        $this->services = $services;
    }

    public function updateOfferStatus(Comms $comms, Request $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($comms, $request) {
                $this->services
                    ->validateRequest($request)
                    ->updateCommOffer($comms)
                    ->updateOffer();
            });
            return response()->json(['message' => 'Offer updated successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function makeOffer(Comms $comms, Request $request): JsonResponse
    {
        try {
            $this->services
                ->validateOfferRequest($request)
                ->updateOfferAmount($comms)
                ->createOffer();
            return response()->json(['message' => 'Send an new offer successfully'], 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function cancelOffer(Offer $offer): JsonResponse
    {
        try {
            DB::transaction(function () use ($offer) {
                $this->services
                    ->setOfferModel($offer)
                    ->updateCommunication()
                    ->cancelOffer();
            });

            return response()->json(['message' => 'The offer is canceled successfully'], 201);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

}
