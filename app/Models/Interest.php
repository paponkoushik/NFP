<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interest extends Model
{
    /**
     * Get the parent of the areas.
     *
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Interest::class, 'parent_id')->select('id', 'name', 'slug');
    }

    /**
     * Get the chilren of the individual areas.
     *
     */
    public function children(): HasMany
    {
        return $this->hasMany(Interest::class, 'parent_id')
            ->select('id', 'name', 'slug', 'parent_id')
            ->ofSort();
    }

    /**
     * add query scope to get only parent area
     */
    public function scopeOfParent($query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * add query scope to get only parent area
     */
    public function scopeOfSort($query, $direction = 'asc'): Builder
    {
        return $query->orderBy('name', $direction);
    }

    /**
     * Get all parent areas with childs
     */
    public static function getParentsWithChilds()
    {
        return self::select('id', 'name', 'slug')
            ->with(['children' => fn ($query) => $query->with('children')])
            ->ofParent()
            ->ofSort('asc')
            ->get();
    }
}
