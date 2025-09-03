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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
        'location' => env('GOOGLE_CLOUD_LOCATION', 'us-central1'),
    ],

    'firebase' => [
        'api_key' => env('FIREBASE_API_KEY') ?: \App\Models\Setting::get('firebase_api_key'),
        'auth_domain' => env('FIREBASE_AUTH_DOMAIN') ?: \App\Models\Setting::get('firebase_auth_domain', 'laravel-real-estate-agen-19b83.firebaseapp.com'),
        'project_id' => env('FIREBASE_PROJECT_ID') ?: \App\Models\Setting::get('firebase_project_id', 'laravel-real-estate-agen-19b83'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET') ?: \App\Models\Setting::get('firebase_storage_bucket', 'laravel-real-estate-agen-19b83.firebasestorage.app'),
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID') ?: \App\Models\Setting::get('firebase_messaging_sender_id'),
        'app_id' => env('FIREBASE_APP_ID') ?: \App\Models\Setting::get('firebase_app_id'),
        'measurement_id' => env('FIREBASE_MEASUREMENT_ID') ?: \App\Models\Setting::get('firebase_measurement_id'),
    ],

];
