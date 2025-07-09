<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgUser extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'organisation_id', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Get the user of the org-user.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email');
    }

    /**
     * Get the organisation of the org-user.
     *
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class)->select('id', 'org_name', 'org_type', 'user_hash');
    }

    /**
     * Scope a query to include all active organisation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActive($query)
    {
        return $query->whereStatus('active');
    }
}
