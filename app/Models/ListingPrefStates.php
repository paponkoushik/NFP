<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingPrefStates extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function listingPreference(): BelongsTo
    {
        return $this->belongsTo(ListingPreference::class, 'listing_preference_id');
    }
}
