<?php

namespace Simtabi\Laraphone\Facades;

use Illuminate\Support\Facades\Facade;

class LaraphoneFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraphone';
    }
}
