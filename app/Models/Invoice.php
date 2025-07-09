<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'invoice_no', 'original_amount', 'invoice_amount', 'invoice_date', 'payment_from', 'payment_to', 'payment_on', 'invoice_details', 'payment_details', 'notes', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invoice_details' => 'object',
        'payment_details' => 'object',
    ];

    /**
     * Get the subscription of that invoice.
     *
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function scopeOfActive(Builder $query): Builder
    {
        return $query->whereStatus('active');
    }

}
