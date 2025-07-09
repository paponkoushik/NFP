<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Models\Traits\UpdatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasUuids, HasFactory, SoftDeletes, CreatedBy, UpdatedBy;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'path', 'file_type', 'price', 'summary', 'is_free', 'total_download', 'total_purchased', 'organisation_id', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_free' => 'boolean',
    ];

    /**
     * Get the organisation of the document.
     *
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    /**
     * Get the document collections of the document.
     *
     */
    public function documentCollections()
    {
        return $this->hasMany(DocumentCollection::class)->select('id', 'document_id', 'collection_id');
    }

    /**
     * Get the document collections of the document.
     *
     */
    public function documentTags()
    {
        return $this->belongsToMany(Tag::class, 'document_tags');
    }

    /**
     * Get the collections of the document.
     *
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'document_collections');
    }

    /**
     * Get the owner who owns the document.
     *
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    /**
     * Get the updator who modify the document.
     *
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'full_name');
    }

    /**
     * Load relation.
     *
     */
    public function scopeLoadRelation($query)
    {
        return $query->with('documentCollections', 'documentTags', 'collections');
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
     * Scope a query to include document of a given organisation ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  char $organisationId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrganisation($query, $organisationId = null)
    {
        if (empty($organisationId)) {
            return $query;
        }

        return $query->whereOrganisationId($organisationId);
    }

    /**
     * Scope a query to include all published document.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPublished($query)
    {
        return $query->whereStatus('published');
    }

}
