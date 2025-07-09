<?php

namespace App\Models;

use App\Enums\OfferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comms extends Model
{
    use HasFactory;

    protected $table = 'comms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id', 'to_org_id', 'from_org_id', 'is_offered', 'to_org_anonymous', 'from_org_anonymous', 'offered_amount',
        'from_org_last_seen_at', 'to_org_last_seen_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_offered' => 'boolean',
        'to_org_anonymous' => 'boolean',
        'from_org_anonymous' => 'boolean',
        'offered_amount' => 'float',
        'offer_status' => OfferStatus::class,
        'from_org_last_seen_at' => 'datetime',
        'to_org_last_seen_at' => 'datetime'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class)->select('id', 'title', 'created_at');
    }

    public function receiverOrg()
    {
        return $this->belongsTo(Organisation::class, 'from_org_id')->select('id', 'org_name');
    }

    public function senderOrg()
    {
        return $this->belongsTo(Organisation::class, 'from_org_id')->select('id', 'org_name', 'alias');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function latestOffer(): HasOne
    {
        return $this->hasOne(Offer::class)->latestOfMany();
    }

    public function scopeOfOrganisation($query)
    {
        return $query->where('to_org_id', authUserOrgId());
    }

    public function scopeFromOrganisation($query)
    {
        return $query->where('from_org_id', authUserOrgId());
    }

    public function scopeFromToOrganisation($query)
    {
        return $query
            ->where('to_org_id', authUserOrgId())
            ->orwhere('from_org_id', authUserOrgId());
    }
}
