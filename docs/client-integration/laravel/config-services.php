<?php

/**
 * Tambahkan blok 'ssb' ini ke dalam array di config/services.php milik ESS.
 * (Jangan menimpa seluruh file — cukup tambahkan entri ini.)
 */

return [

    // ... entri services lain milik ESS ...

    'ssb' => [
        'base_url'      => env('SSB_BASE_URL', 'http://localhost:8000'),
        'client_id'     => env('SSB_CLIENT_ID'),
        'client_secret' => env('SSB_CLIENT_SECRET'), // kosong utk client public/PKCE
        'redirect'      => env('SSB_REDIRECT_URI', 'http://localhost:8001/auth/ssb/callback'),
    ],

];
