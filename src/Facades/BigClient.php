<?php

namespace MadBoy\BigCommerceAPI\Facades;

use Illuminate\Support\Facades\Facade;

class BigClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bigcommerce-client';
    }
}