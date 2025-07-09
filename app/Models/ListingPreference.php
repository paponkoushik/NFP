<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListingPreference extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'states'  => 'array',
        'suburbs' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function stateList(): HasMany
    {
        return $this->hasMany(ListingPrefStates::class, 'listing_preference_id');
    }

    public function suburbList(): HasMany
    {
        return $this->hasMany(ListingPrefSuburbs::class, 'listing_preference_id');
    }
}
