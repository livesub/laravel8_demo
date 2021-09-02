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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    //소셜 로그인 관련
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'project_id'=> env('GOOGLE_PROJECT_ID'),
        //'auth_uri' => env('GOOGLE_AUTH_URL'),
        //'token_uri' => env('GOOGLE_TOKEN_URL'),
        'auth_provider_x509_cert_url'=>"https://www.googleapis.com/oauth2/v1/certs",
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
        'javascript_origins' => "http://localhost:8000"
    ],

    'kakao' => [
        'client_id' => env('KAKAO_KEY'),    //<REST API 키>
        'client_secret' => env('KAKAO_SECRET'),
        'redirect' => env('KAKAO_REDIRECT_URI'),
    ],

    'naver' => [
        'client_id' => env('NAVER_KEY'),
        'client_secret' => env('NAVER_SECRET'),
        'redirect' => env('NAVER_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
];
