<?php

return [
    'client_id' => env('ZOHO_CLIENT_ID'),
    'client_secret' => env('ZOHO_CLIENT_SECRET'),
    'oauth_base_url' => env('ZOHO_OAUTH_BASE_URL', 'https://accounts.zoho.com'),
    'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
    'scopes' => env('ZOHO_SCOPES')
];
