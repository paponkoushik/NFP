<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrgPrefValue extends Model
{
    use HasFactory;

    protected $table = 'org_pref_values';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function orgPreference(): BelongsTo
    {
        return $this->belongsTo(OrgPreference::class, 'org_preference_id');
    }

    public function states(): HasMany
    {
        return $this->hasMany(OrgPrefValState::class, 'org_pref_val_id');
    }

    public function suburbs(): HasMany
    {
        return $this->hasMany(OrgPrefValSuburb::class, 'org_pref_val_id');
    }
}
