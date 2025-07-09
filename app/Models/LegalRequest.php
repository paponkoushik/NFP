<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use App\Enums\UserRoles;
use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

class LegalRequest extends Model
{
    use HasUuids, HasFactory, CreatedBy, SoftDeletes;

    protected $casts = [
        'is_request_accepted' => 'boolean'
    ];

    public function legalRequestNotes(): HasMany
    {
        return $this->hasMany(LegalRequestNote::class)->latest();
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class)
            ->with('category')
            ->select('id', 'category_id', 'title', 'description');
    }

    public function primaryOrg()
    {
        return $this->belongsTo(Organisation::class, 'primary_org_id')
            ->select('id', 'org_name', 'org_type', 'created_by');
    }

    public function secondaryOrg(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'secondary_org_id')
            ->with('createdBy:id,first_name,last_name,phone')
            ->select('id', 'org_name', 'org_type', 'created_by');
    }

    public function requestedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_user_id')
            ->select('id', 'first_name', 'last_name', 'email', 'phone');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to')->select('id', 'first_name', 'last_name', 'email');
    }

    public function workflowStages(): HasMany
    {
        return $this->hasMany(Workflow::class, 'stage_code', 'workflow_stage')
            ->select('id', 'stage_code', 'status_name')
            ->oldest('sequence');
    }

    public function legalPartnerAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'legal_partner_admin_id')
            ->select('id', 'full_name', 'eamil');
    }

    public function legalPartner(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'legal_partner_id')->select('id', 'org_name', 'org_type');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    public function scopeFilters(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function scopeOfAdvertisement(Builder $query, string | null $status = null): Builder
    {
        if (empty($status)) {
            return $query;
        }

        return $query->whereRequestStatus($status);
    }

    public static function loadRelationships(): array {
        $with = ['listing', 'primaryOrg', 'secondaryOrg'];

        return Gate::allows(UserRoles::OrgAdmin->value) ? $with : array_merge($with, [
            'assignedTo',
            'requestedUser',
            'workflowStages',
            'legalRequestNotes.createdBy'
        ]);
    }
}
