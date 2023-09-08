<?php

namespace Wawans\LaravelSupport;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wawans\LaravelSupport\Skeleton\SkeletonClass
 */
class LaravelSupportFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-support';
    }
}
