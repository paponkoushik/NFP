<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomField extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
    ];

    public function interestCfMappings(): HasMany
    {
        return $this->hasMany(interestCfMappings::class);
    }
}
