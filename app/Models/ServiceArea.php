<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceArea extends Model
{
    use CreatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'parent_id', 'status'
    ];

    /**
     * Get the parent of the service area.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ServiceArea::class, 'parent_id')->select('id', 'name', 'code');
    }

    /**
     * Get the chilren of the individual service areas.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ServiceArea::class, 'parent_id')
            ->select('id', 'name', 'parent_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the owner who owns the area.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name');
    }

    /**
     * URL query builder of filters record
     */
    public function scopeFilter($query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    /**
     * Scope a query to include all active industry.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActive($query): Builder
    {
        return $query->whereStatus('active');
    }

    /**
     * add query scope to get only parent area
     */
    public function scopeOfParent($query): Builder {
        return $query->whereNull('parent_id');
    }

    /**
     * add query scope to get only parent area
     */
    public function scopeOfSort($query, $direction = 'asc'): Builder {
        return $query->orderBy('name', $direction);
    }

    /**
     * Get all parent areas with childs
     */
    public static function getParentsWithChilds() {
        return self::select('id', 'name')
            ->with('children')
            ->ofParent()
            ->ofSort('asc')
            ->get();
    }
}
