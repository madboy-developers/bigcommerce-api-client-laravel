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
     * Big Commerce has multiple api versions.
     * This version the version which will going to be use by BigCommerceAPI class
     * Default Value is : v3
     */
    'api_version' => env('BC_API_VERSION', 'v3'),

    /**
     * Big Commerce API Client Class.
     * You can modify client by extending it. Just replace the new class here.
     */
    'big_client' => null,

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
