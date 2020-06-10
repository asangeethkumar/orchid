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
 /* ravasaheb code*/
    'api_base_url'=>[
    'api_url'=> 'http://dameeko.com/orchid/orchid_v0.0.1/public/api'  
  ],
  'google' => [
      'client_id' => '993744600036-frqdom3a558etgv4qtvri39pbauhf58u.apps.googleusercontent.com',
      'client_secret' => 'SN7j8bXs5CVWr-_FSQ6wJb74',
      'redirect' => 'http://localhost:8000/login/google/callback'
  ],
  'instagram' => [
      'client_id' => '166668d74d46478f87cafd25543a5e19',
      'client_secret' => 'c4fa3c8d2e454a5d981e33e13b57bd1f',
      'redirect' => 'http://localhost:8000/login/instagram/callback'
  ],
  'facebook' => [
      'client_id'     => '2017453211635217',
      'client_secret' => '02518e4155e3f69c1b6e0dfcc1dca10e',
      'redirect'      => 'http://localhost:8000/login/facebook/callback',
  ],
  'linkedin' => [
      'client_id' => '86ldjmehl2zaxf',
      'client_secret' => 'ad9vpNEiKOFHRmm7',
      'redirect' => 'http://localhost:8000/login/linkedin/callback'
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
'slack' => [
      'client_id' => '542744906485.543967119046',
      'client_secret' => 'efd9d08aaa1de393c4ade12f698d585d',
      'redirect' => 'http://localhost:8000/slack/auth/callback',
      'redirect_connect_social_media' => 'http://localhost:8000/connect/slack/callback',
      'redirect_friend_list_uri' => 'http://localhost:8000/connect/slack/get-friends',
  ],

   /* ravasaheb code*/

];
