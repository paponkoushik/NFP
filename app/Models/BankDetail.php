<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankDetail extends Model
{
    use HasFactory, CreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organisation_id', 'account_name', 'account_number', 'bsb_no', 'bank_name', 'bank_no', 'branch_name', 'pay_id', 'is_default', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean'
    ];

    /**
     * Get the organisation that own the bank detail.
     * 
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the owner who owns the bank detail.
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
     * Scope a query to include all active bank detail.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    /**
     * Scope a query to include all active organisation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActive($query)
    {
        return $query->whereStatus('active');
    }
    
}
