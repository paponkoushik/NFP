<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'document_id', 'is_favourite'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_favourite' => 'boolean'
    ];

    /**
     * Get the user of the saved-document.
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email');
    }

    /**
     * Get the document of the saved-document.
     * 
     */
    public function document()
    {
        return $this->belongsTo(Document::class)->select('id', 'title');
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
     * Scope a query to include all favourite saved-document.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfFavourite($query)
    {
        return $query->whereIsFavourite(true);
    }

}
