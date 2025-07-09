<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedSearch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'keyword', 'query', 'count'
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
     * Get the user of the saved-search.
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email');
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
     * Scope a query to include legal support of a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  char $userId 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->whereUserId($userId);
    }

}
