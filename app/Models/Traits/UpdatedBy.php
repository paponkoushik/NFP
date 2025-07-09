<?php

namespace App\Models\Traits;

trait UpdatedBy
{
    /**
     * Setup model event hook.
     * 
     * @return void
     */
    protected static function bootUpdatedBy()
    {
        static::updating(function ($model) {
            $model->{$model->getUpdatedKeyName()} = isSuperAdminImpersonate() ? null : auth()->user()->id;
        });
    }

    /**
     * Get key name of the hook.
     * 
     * @return string
     */
    public function getUpdatedKeyName()
    {
        return 'updated_by';
    }

    /**
     * Get the updator who modify the model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'full_name');
    }

}