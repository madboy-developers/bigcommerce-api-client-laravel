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
     * Auto retry based on bigcommerce header
     * Bigcommerce sends retry after header if limit is reached :
     * https://developer.bigcommerce.com/api-docs/getting-started/about-our-api#:~:text=v2/products/7-,X%2DRetry%2DAfter,-integer
     * BigCommerce API client will going to sleep for specified value plus 1 and retry the same API for auto API fail recovery.
     */
    'auto_retry_after' => true,

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
