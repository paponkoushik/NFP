<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgServiceArea extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'org_service_areas';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the area of the org-user.
     *
     */
    public function serviceArea()
    {
        return $this->belongsTo(ServiceArea::class)->select('id', 'name', 'parent_id');
    }

    /**
     * Get the organisation of the org-user.
     *
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type');
    }
}
