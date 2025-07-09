<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrgPreference extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'where'         => 'array',
        'where_looking' => 'array',
        'where_offer'   => 'array',
    ];

    /**
     * Get the organisation of the org-user.
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function prefValues(): HasOne|HasMany // if org_preference type is both then hasMany else hasOne
    {
        if ($this->type === 'both') {
            return $this->hasMany(OrgPrefValue::class, 'org_preference_id');
        }

        return $this->hasOne(OrgPrefValue::class, 'org_preference_id');
    }
}
