<?php

namespace App\Models\Traits;

trait CreatedBy
{
    /**
     * Setup model event hook.
     *
     * @return void
     */
    protected static function bootCreatedBy()
    {
        static::creating(function ($model) {
            $model->{$model->getCreatedKeyName()} = isSuperAdminImpersonate() ? null : auth()->id() ?? null;
        });
    }

    /**
     * Get key name of the hook.
     *
     * @return string
     */
    public function getCreatedKeyName()
    {
        return 'created_by';
    }

    /**
     * Get the owner who owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'full_name');
    }
}
