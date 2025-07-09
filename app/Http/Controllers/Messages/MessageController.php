<?php

namespace App\Http\Controllers\Messages;

use App\Http\Resources\Communication\CommsResource;
use App\Models\Comms;
use App\Models\Listing;
use App\Models\Organisation;
use App\Services\MessageServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    protected $services;

    public function __construct(MessageServices $services)
    {
        $this->services = $services;
    }

    public function index(): View
    {
        return view('messages.index');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $this->services
                    ->validateRequest($request)
                    ->checkCommunicationExists()
                    ->storeCommunication()
                    ->storeOffer()
                    ->storeMessage();
            });

            return response()->json(['message' => 'Message sent successfully'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getOwnAndReplied(Listing $list): JsonResponse
    {
        $communication = $this->services->getOwnAndReplied([
            'to_org_id' => $list->organisation_id,
            'listing_id' => $list->id
        ]);

        return response()->json($communication, 200);
    }

    public function getOrgOwnAndReplied(Organisation $organisation): JsonResponse
    {
        $communication = $this->services->getOwnAndReplied([
            'to_org_id' => $organisation->id,
            'listing_id' => null
        ]);

        return response()->json($communication, 200);
    }
}
