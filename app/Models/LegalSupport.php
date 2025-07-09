<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalSupport extends Model
{
    use HasUuids, HasFactory, CreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ads_offer_id', 'advertisement_id', 'requested_user_id', 'requested_org_id', 'legal_partner_admin_id', 'legal_partner_id', 'lawyer_id', 'request_note', 'request_init_note', 'request_summary', 'lawyer_note', 'is_request_accepted', 'request_status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_request_accepted' => 'boolean'
    ];

    /**
     * Get the ads offer of the legal support.
     *
     */
    public function adsOffer()
    {
        return $this->belongsTo(AdsOffer::class);
    }

    /**
     * Get the advertisement of the legal support.
     *
     */
    public function advertisement()
    {
        return $this->belongsTo(Listing::class)->select('id', 'title', 'description', 'price');
    }

    /**
     * Get the requested user of the legal support.
     *
     */
    public function requestedUser()
    {
        return $this->belongsTo(User::class, 'requested_user_id')->select('id', 'full_name', 'eamil');
    }

    /**
     * Get the requested organisation of the legal support.
     *
     */
    public function requestedOrganisation()
    {
        return $this->belongsTo(Organisation::class, 'requested_org_id')->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the legal partner admin of the legal support.
     *
     */
    public function legalPartnerAdmin()
    {
        return $this->belongsTo(User::class, 'legal_partner_admin_id')->select('id', 'full_name', 'eamil');
    }

    /**
     * Get the legal partner of the legal support.
     *
     */
    public function legalPartner()
    {
        return $this->belongsTo(Organisation::class, 'legal_partner_id')->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the lawyer of the legal support.
     *
     */
    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id')->select('id', 'full_name', 'eamil');
    }

    /**
     * Get the owner who owns the legal support.
     *
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    /**
     * Query Filter.
     *
     * @param  QueryFilter $filters
     * @return Collection
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Scope a query to include legal support of a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfAdvertisement($query, $status = null)
    {
        if (empty($status)) {
            return $query;
        }

        return $query->whereRequestStatus($status);
    }
}
