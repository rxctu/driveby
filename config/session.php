<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => (int) env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // SECURITY: Encrypt session data at rest
    'encrypt' => true,

    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => env('SESSION_TABLE', 'sessions'),
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'epidrive'), '_').'_session'
    ),

    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),

    // SECURITY: Only send cookie over HTTPS in production
    'secure' => env('SESSION_SECURE_COOKIE', env('APP_ENV') === 'production'),

    // SECURITY: Prevent JavaScript access to session cookie
    'http_only' => true,

    // SECURITY: Strict same-site to prevent CSRF via cross-origin requests
    'same_site' => 'strict',

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
