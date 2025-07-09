<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Offer\OfferListResource;
use App\Models\Offer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MyOfferController extends Controller
{
    public function index(): View
    {
        return view('offers.own.index');
    }

    public function getOwnOffers(): AnonymousResourceCollection
    {
        return OfferListResource::collection(
            Offer::query()
                ->ownOffers()
                ->with(['list', 'communication'])
                ->latest()
                ->paginate(request('limit') ?? PAGINATE_LIMIT)
        );

    }

    public function getListOffers(string $listId): AnonymousResourceCollection
    {
        return OfferListResource::collection(
            Offer::query()
                ->with(['list', 'communication'])
                ->where('listing_id', $listId)
                ->latest()
                ->paginate(request('limit') ?? PAGINATE_LIMIT)
        );

    }
}
