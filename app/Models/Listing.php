<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Models\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Actions\Filters\QueryFilter;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasUuids, HasFactory, SoftDeletes, CreatedBy, UpdatedBy, Sluggable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'organisation_id',
        'location_id',
        'category_id',
        'title',
        'description',
        'type',
        'city',
        'state',
        'postcode',
        'address',
        'visits',
        'is_anonymous',
        'archived_at',
        'images',
        'status',
        'preferences',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'images'       => 'array',
        'is_anonymous' => 'boolean',
        'preferences'  => 'array',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class)
            ->select('id', 'org_name', 'org_type', 'logo', 'summary', 'contact_email', 'created_at');
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)->select('id', 'address', 'city', 'state', 'postcode', 'region', 'lat', 'long');
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Comms::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')
            ->select('id', 'first_name', 'last_name');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(ListingPreference::class, 'listing_id');
    }

    public function scopeLoadRelation($query): Builder
    {
        return $query->with([
            'organisation',
            'category',
            'location',
            'createdBy',
            'category.parent',
            'category.parent.parent',
            'offers',
            'offers.communication',
            'preference',
            'preference.stateList',
            'preference.suburbList',
        ]);
    }

    public function scopeWithCommunications(Builder $query): Builder
    {
        return $query->with(['communications' => function ($q) {
//            $q->with('senderOrg.users')->whereNotNull('listing_id')->where('to_org_id', authUserOrgId());
            /* TODO: 18-09-2023 Please have a look here. Is commented code important?*/
            $q->with(['messages', 'senderOrg.users'])
                ->whereNotNull('listing_id')
                ->where(function ($query) {
                    $query->where('to_org_id', authUserOrgId())
                        ->orwhere('from_org_id', authUserOrgId());
                });
        }])->whereHas('communications');
    }

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
