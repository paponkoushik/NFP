<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{
    use HasFactory, CreatedBy;

    protected $fillable = [
        'name', 'type', 'status'
    ];

    protected $casts = [
        //
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }

    public function scopeFilter(Builder $query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }

    public static function cacheFlush()
    {
        Cache::forget('tags');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->whereType($type);
    }

    public function scopeOfActive(Builder $query): Builder
    {
        return $query->whereStatus('active');
    }

}
