<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    
    'twitter' => [
       'client_id' => 'n2BDhUHg6AHuqHAaHUoYoibRm',
       'client_secret' => '1pnywKapQPBXE75yh9CiKxfq0Fupo2hQt1gLKiWMRKf2msRotb',
       'consumer_key' => 'n2BDhUHg6AHuqHAaHUoYoibRm',
       'consumer_secret' => '1pnywKapQPBXE75yh9CiKxfq0Fupo2hQt1gLKiWMRKf2msRotb',
       'access_token'    => '1092716118362357760-1sFesX8rbk8CrSA87Gn9VilebghmP4',
       'access_secret'   => 'q64fz0gnE57Tq3N0kDzZffWNxQixWsxFHYNWxoSvEDM9f',
       'redirect' => 'http://localhost:8000/login/twitter/callback',
       'redirect_connect_social_media' => 'http://localhost:8000/connect/twitter/callback'
   ],

];
