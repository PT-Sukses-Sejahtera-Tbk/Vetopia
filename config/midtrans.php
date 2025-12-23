<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans Payment Gateway
    |
    */

    // Your Merchant Server Key
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    // Your Merchant Client Key
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    // Set to true for production, false for sandbox/testing
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Enable sanitization, highly recommended
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    // Enable 3D Secure
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
