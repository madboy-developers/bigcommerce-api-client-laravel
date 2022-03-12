<?php

namespace MadBoy\BigCommerceAPI\Facades;

use Illuminate\Support\Facades\Facade;
use MadBoy\BigCommerceAPI\BigCommerce as BigClient;

/**
 * @method static BigClient query($endPoint)
 * @method static all($query_data = null)
 * @method static get($id, $query_data = null)
 * @method static create($form_data = [])
 * @method static update($id, $form_data = [])
 * @method static updateMultiple($form_data = [])
 * @method static delete($id)
 * @method static deleteMultiple($ids = [])
 */
class BigAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bigcommerce-api';
    }
}
