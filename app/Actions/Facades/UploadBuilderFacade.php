<?php

namespace App\Actions\Facades;

use App\Actions\UploadBuilder;
use Illuminate\Support\Facades\Facade;

class UploadBuilderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     * 
     * @return instance
     */
    protected static function getFacadeAccessor()
    {
        return UploadBuilder::class;
    }

}