<?php

namespace App\Http\Controllers\Chat;

use App\Http\Resources\Communication\GroupByMessageResource;
use App\Models\Comms;
use App\Models\Listing;
use App\Models\Message;
use App\Services\ChatServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Communication\CommsResource;
use App\Http\Resources\Communication\MessageResource;
use App\Http\Resources\Communication\CommsListingResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    protected $services;

    public function __construct(ChatServices $chatServices)
    {
        $this->services = $chatServices;
    }

    public function index(): JsonResponse|RedirectResponse
    {
        if (request()->wantsJson()) {
            return response()->json([
                'groups' => CommsListingResource::collection(Listing::withCommunications()->get()),
                'contacts' => CommsResource::collection(
                    Comms::with(['messages','senderOrg.users'])->whereNull('listing_id')->fromToOrganisation()->get()
                )
            ]);
        }

       return redirect()->to('/messages');
    }

    public function show(int $communicationId): AnonymousResourceCollection
    {
        return MessageResource::collection(
            Message::with(['user', 'comms'])
                ->where('comms_id', $communicationId)
                ->latest()
                ->paginate(50)
        );
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $this->services
                    ->validateRequest($request)
                    ->updateCommunication()
                    ->storeMessage();
            });

            return response()->json(['message' => 'Message sent successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function unSeenMessageCount(): JsonResponse
    {
        $count = Comms::query()->where(function ($q) {
            $q->where('to_org_id', authUserOrgId())
                ->orWhere('from_org_id', authUserOrgId());
        })->with('latestMessage')
            ->get()
            ->reject(function (object $item) {
                if ($item->to_org_id === authUserOrgId()) {
                    $item->is_seen = $item->to_org_last_seen_at >= $item->latestMessage->created_at;
                } else if ($item->from_org_id === authUserOrgId()) {
                    $item->is_seen = $item->from_org_last_seen_at >= $item->latestMessage->created_at;
                }
            return $item->is_seen;

        })->count();

        return response()->json($count);
    }

    public function updateSeenTime(Comms $comms): JsonResponse
    {
        try {
            $this->services->updateCommSeenTime($comms);

            return response()->json(['message' => 'Communication time updated successfully'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

}
