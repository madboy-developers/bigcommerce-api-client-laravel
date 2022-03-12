<?php

namespace MadBoy\BigCommerceAPI\Facades;

use Closure;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Facade;
use MadBoy\BigCommerceAPI\BigCommerceClient;

/**
 * @method static string|null getStoreHash()
 * @method static void setGetStoreHash(Closure $getStoreHash)
 * @method static string|null getAccessToken()
 * @method static void setGetAccessToken(Closure $getAccessToken)
 * @method static PendingRequest client()
 *
 * @see BigCommerceClient
 */
class BigClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bigcommerce-client';
    }
}