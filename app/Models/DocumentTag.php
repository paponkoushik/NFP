<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentTag extends Model
{
    use HasFactory, CreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_id', 'document_id'
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
     * Get the document of the document-tag.
     * 
     */
    public function document()
    {
        return $this->belongsTo(Document::class)->select('id', 'title');
    }

    /**
     * Get the tag of the document-tag.
     * 
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class)->select('id', 'name');
    }

    /**
     * Get the owner who owns the document-tag.
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
    
}
