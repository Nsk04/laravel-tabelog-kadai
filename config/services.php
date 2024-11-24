<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
    'key' => env('pk_test_51Q7BKB04OpOW60oOfTcC2fGsxlQgqhlXSomQIPMuFNy1QPsoSbhbgQOkbmYpmZJvTw5KwaezkWShWA1g3ZLC0cOq00HWhm5oMf'),
    'secret' => env('sk_test_51Q7BKB04OpOW60oOYV70Syf8be4dycbKBID2tKhJTJZChXnijkFzSL49csOEvG355y6VAOwAVJNEN8pNPKKwoK3800P9B4QVPZ'),
    ],

];
