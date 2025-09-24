<?php

namespace Mortezaa97\Shop;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezaa97\Shop\Skeleton\SkeletonClass
 */
class ShopFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shop';
    }
}
