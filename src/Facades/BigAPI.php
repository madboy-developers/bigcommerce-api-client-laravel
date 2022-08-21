<?php

namespace MadBoy\BigCommerceAPI\Facades;

use Illuminate\Support\Facades\Facade;
use MadBoy\BigCommerceAPI\BigCommerce as BigClient;
use MadBoy\BigCommerceAPI\BigCommerceAPI;

/**
 * @method static BigClient query($endPoint)
 * @see BigCommerceAPI
 */
class BigAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bigcommerce-api';
    }
}
