<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterestCfMapping extends Model
{
    public function customField(): BelongsTo
    {
        return $this->belongsTo(CustomField::class);
    }

    public function interest(): BelongsTo
    {
        return $this->belongsTo(Interest::class);
    }

    public function interestCfValues(): HasMany
    {
        return $this->hasMany(interestCfValues::class);
    }
}
