<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use App\Enums\UserRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'exclude_fields'       => 'array',
        'exclude_field_values' => 'array',
        'custom_label'         => 'array',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public function scopeGetOptionsList(Builder $query): Collection
    {
        return $query->with('childs.childs')
            ->ofActive()
            ->whereNull('parent_id')
            ->oldest('name')
            ->get();
    }

    public static function getParentsWithChilds(): mixed
    {
        return self::where(function (Builder $query) {
            $query->whereNull('exclude_for');
            if (auth()->user()->role == UserRoles::Individual->value) {
                $query->orWhere('exclude_for', '!=', 'inv');
            } else {
                $query->orWhere('exclude_for', '!=', 'org');
            }

        })
            ->with(['childs' => function (HasMany $query) {
                $query->with('childs')
                    ->where(function (Builder $query) {
                        $query->whereNull('exclude_for');
                            if (auth()->user()->role == UserRoles::Individual->value) {
                                $query->orWhere('exclude_for', '!=', 'inv');
                            } else {
                                $query->orWhere('exclude_for', '!=', 'org');
                            }
                    })
                    ->ofActive();
            }])
            ->ofActive()
            ->ofParent()
            ->ofSort()
            ->get();
    }

    public function scopeOfParent(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOfActive(Builder $query): Builder
    {
        return $query->whereStatus('active');
    }

    public function scopeOfSort(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('name', $direction);
    }
}
