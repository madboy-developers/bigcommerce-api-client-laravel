<?php
/**
 * All kind of Big Commerce API configuration will be here
 */
return [
    /**
     * Big Commerce API base url
     * Default Value is : https://api.bigcommerce.com/stores
     */
    'base_url' => env('BC_BASE_URL', 'https://api.bigcommerce.com/stores/'),

    /**
     * You can use default configuration of Big Commerce or
     * you can make it dynamic by creating custom BigCommerceClient class
     * by extending abstract MadBoy\BigCommerceAPI\BigCommerceClient::class and just pass above
     */
    'api_config' => [
        'store_hash' => env('BIG_STORE_HASH'),
        'access_token' => env('BIG_ACCESS_TOKEN'),
    ]
];
