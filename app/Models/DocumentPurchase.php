<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentPurchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id', 'organisation_id', 'purchase_at', 'download_hash', 'total_download'
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
     * Get the document of the document-purchase.
     * 
     */
    public function document()
    {
        return $this->belongsTo(Document::class)->select('id', 'title');
    }

    /**
     * Get the organisation of the document-purchase.
     * 
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
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
     * Scope a query to include document purchase of a given document ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $documentId
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
