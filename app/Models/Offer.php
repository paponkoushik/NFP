<?php

namespace App\Models;

use App\Enums\OfferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id', 'offered_org_id', 'offered_at', 'offer_details', 'offer_amount', 'agreed_amount', 'price_type',
        'is_fixed_price', 'offered_accepted_at', 'note', 'status', 'created_by'
    ];

    protected $casts = [
        'offer_amount' => 'float',
        'agreed_amount' => 'float',
        'status' => OfferStatus::class,
        'offered_at' => 'datetime',
        'offered_accepted_at' => 'datetime',
        'is_fixed_price' => 'boolean'
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function communication(): BelongsTo
    {
        return $this->belongsTo(Comms::class, 'comms_id');
    }

    public function scopeOwnOffers($query)
    {
        return $query->where('offered_org_id', authUserOrgId());
    }
}
