<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'document_id', 'document_price', 'gst'
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
     * Get the user of the order-detail.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name');
    }

    /**
     * Get the document of the order-detail.
     *
     */
    public function document()
    {
        return $this->belongsTo(Document::class)->select('id', 'title', 'path');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
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
     * Scope a query to include order detail of a given document ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $documentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDocument($query, $documentId = null)
    {
        if (empty($documentId)) {
            return $query;
        }

        return $query->whereDocumentId($documentId);
    }

}
