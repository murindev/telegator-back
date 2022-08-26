<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['get', 'post', 'options'],

    'allowed_origins' => ['http://tgator.front','http://jsgu.ru','http://jsgu.ru/','http://localhost:8080'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['X-Xsrf-Token', '*'],
        //['DNT','X-CustomHeader','Keep-Alive','User-Agent','X-Requested-With','If-Modified-Since','Cache-Control','Content-Type','Content-Range','Range','X-Xsrf-Token'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
