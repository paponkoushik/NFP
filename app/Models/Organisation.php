<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organisation extends Model
{
    use HasUuids, HasFactory, SoftDeletes, Sluggable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'org_name', 'org_type', 'client_type', 'contact_email', 'contact_phone', 'logo', 'abn', 'acn', 'summary',
        'details', 'website', 'alias', 'max_user', 'others', 'status', 'created_by', 'set_preference_at'
    ];

    protected $casts = [
        'others' => 'array',
        'set_preference_at' => 'datetime'
    ];

    public function serviceAreas(): BelongsToMany
    {
        return $this
            ->belongsToMany(ServiceArea::class, 'org_service_areas')->select('name', 'parent_id');
    }

    public function interests(): BelongsToMany
    {
        return $this
            ->belongsToMany(Interest::class, 'org_interests', 'organisation_id', 'interest_id')
            ->select('name', 'slug', 'parent_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'org_categories',
            'organisation_id',
            'category_id'
        );
    }

    public function interestCfValues(): HasMany
    {
        return $this->hasMany(OrgInterestCfValue::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(OrgLocation::class);
    }

    public function primaryAddress(): HasOne
    {
        return $this->hasOne(OrgLocation::class)->where('is_primary', true);
    }

    public function otherLocations(): HasMany
    {
        return $this->hasMany(OrgLocation::class)->where('is_primary', false);
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(OrgPreference::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'org_users')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.avatar', 'users.last_login_at', 'users.is_online')
            ->withPivot(['is_primary', 'status']);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->select('id', 'organisation_id', 'subs_start_date', 'subscription_period', 'is_trial', 'form', 'to', 'trial_ends_at');
    }

    /*public function getLogoAttribute($value)
    {
        return asset($value ? '/storage/logos/' . $value : '/assets/img/photos/b' . rand(4, 7) . '.jpg');
    }*/

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function scopeOfActive(Builder $query): Builder
    {
        return $query->whereStatus('active');
    }

    public static function generateAliasName(): string
    {
        return 'Anonymous ' . rand(1000, 9999);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function getDefaultStepAttribute(): int
    {
        $step = 0;

        if ($this->serviceAreas->count()) {
            $step++;
        }
        if ($this->categories->count()) {
            $step++;
        }
        if ($this->preferences->count()) {
            $step++;
        }
        return $step;
    }
}
