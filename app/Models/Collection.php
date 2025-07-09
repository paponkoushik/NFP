<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use SoftDeletes, HasFactory, CreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'organisation_id', 'parent_id', 'status'
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
     * Get the organisation of the collection.
     *
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the parent of the collection.
     *
     */
    public function parent()
    {
        return $this->belongsTo(Collection::class, 'parent_id')->select('id', 'title');
    }

    /**
     * Get the childs of the collection.
     *
     */
    public function childs()
    {
        return $this->hasMany(Collection::class, 'parent_id')->select('id', 'title', 'parent_id')->oldest('title');
    }

    /**
     * Get the owner who owns the collection.
     *
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    /**
     * Get the childs of the collection.
     *
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_collections');
    }

    /** 
     * Load relations.
     * 
     * @return mixed
     */
    public function scopeLoadRelation($query)
    {
        return $query->with(['documents.documentCollections', 'documents.documentTags', 'childs' => function ($q) {
            $q->with(['documents.documentCollections', 'documents.documentTags', 'childs' => function ($q2) {
                $q2->with('documents.documentCollections', 'documents.documentTags');
            }]);
        }]);
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
     * Scope a query to include all active collection.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActive($query)
    {
        return $query->whereStatus('active');
    }

    /**
     * Scope a query to include all active collection.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
