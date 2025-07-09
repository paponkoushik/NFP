<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgPrefValState extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function orgPrefVal()
    {
        return $this->belongsTo(OrgPrefValue::class, 'org_pref_val_id');
    }
}
