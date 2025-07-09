<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'organisation_id', 'plan_id', 'subs_start_date', 'is_trial', 'subscription_period', 'form', 'to', 'payment_frequency', 'recurring_amount', 'name', 'stripe_id', 'stripe_status', 'stripe_price', 'quantity', 'trial_ends_at', 'ends_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 
    ];

    /**
     * Get the user of the subscription.
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email');
    }

    /**
     * Get the organisation of the subscription.
     * 
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the plan of the subscription.
     * 
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class)->select('id', 'name', 'code');
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

}
