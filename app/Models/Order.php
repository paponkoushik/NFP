<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUuids, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'organisation_id', 'order_no', 'order_amount', 'gst', 'cupon_used', 'has_discount',
        'discount_amount', 'total_amount', 'paid_at', 'transaction_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_discount' => 'boolean'
    ];

    /**
     * Get the user of the order.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name');
    }

    /**
     * Get the organisation of the order.
     *
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    /**
     * @return HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    /**
     * Query Filter.
     *
     * @param QueryFilter $filters
     * @return Collection
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Scope a query to include order of a given order no.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $orderNo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrderNo($query, $orderNo = null)
    {
        if (empty($orderNo)) {
            return $query;
        }

        return $query->whereOrderNo($orderNo);
    }

}
