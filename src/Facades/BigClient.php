<?php

namespace MadBoy\BigCommerceAPI\Facades;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Facade;
use MadBoy\BigCommerceAPI\BigCommerceClient;

/**
 * @method static string|null getStoreHash()
 * @method static void setStoreHash(string $store_hash)
 * @method static string|null getAccessToken()
 * @method static void setAccessToken(string $access_token)
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