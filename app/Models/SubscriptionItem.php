<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'stripe_id', 'stripe_product', 'stripe_price', 'quantity'
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
     * Get the subscription of the subscription item.
     * 
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    
}
