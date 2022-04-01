<?php

return [
    'store_id' => env('CORVUS_STORE_ID', ''),
    'api_key' => env('CORVUS_API_KEY', ''),
    'version' => '1.3',
    'language' => 'hr',
    'currency' => 'HRK',
    'require_complete' => false,
    'endpoint' => env('CORVUS_CHECKOUT_ENDPOINT', 'https://test-wallet.corvuspay.com/checkout/'),
    'status' => env('CORVUS_TRANSACTION_STATUS', ''),
];