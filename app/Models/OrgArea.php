<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgArea extends Model
{    
    /**
     * Get the area of org areas.
     */
    public function area()
    {
        return $this->belongsTo(Area::class)->select('id', 'name', 'parent_id');
    }

    /**
     * Get the organisation of org areas.
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }
}
