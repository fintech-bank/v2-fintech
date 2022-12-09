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

    'pushover' => [
        'token' => env('PUSHOVER_APP_TOKEN'),
    ],

    'yousign' => [
        'api_key' => env('YOUSIGN_API_KEY')
    ],

    'pushbullet' => [
        'access_token' => env('PUSHBULLET_ACCESS_TOKEN')
    ],

    'stripe' => [
        'api_key' => env('STRIPE_API_KEY'),
        'api_secret' => env('STRIPE_API_SECRET'),
    ],

    'twilio' => [
        'twilio_sid' => env("TWILIO_SID"),
        'twilio_auth_token' => env("TWILIO_AUTH_TOKEN"),
        'twilio_verify_sid' => env("TWILIO_VERIFY_SID"),
        'twilio_whatsapp_from' => env('TWILIO_WHATSAPP_FROM')
    ],

    'slack' => [
        'hook' => env('SLACK_HOOK')
    ],

    'gocardless' => [
        'access_token' => env('GOCARDLESS_ACCESS_TOKEN')
    ],

    'mapbox' => [
        'api_key' => env('MAPBOX_TOKEN')
    ],

    'powens' => [
        'client_id' => env('POWENS_CLIENT_ID'),
        'client_secret' => env('POWENS_CLIENT_SECRET'),
        'redirect_uri' => env('POWENS_REDIRECT_URI'),
    ],

    'plaid' => [
        'client_id' => env('PLAID_CLIENT_ID'),
        'secret_key' => env('PLAID_SECRET_KEY'),
        'environment' => env('PLAID_ENVIRONMENT'),
    ],

];
