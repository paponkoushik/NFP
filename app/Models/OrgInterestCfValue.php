<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrgInterestCfValue extends Model
{
    public function interestCfMapping(): BelongsTo
    {
        return $this->belongsTo(InterestCfMapping::class);
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name');
    }
}
