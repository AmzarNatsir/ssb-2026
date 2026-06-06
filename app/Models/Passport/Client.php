<?php

namespace App\Models\Passport;

use Laravel\Passport\Client as PassportClient;
use App\Models\SsoClient;

/**
 * Override Client Passport agar app first-party yang ditandai "trusted"
 * di tabel sso_clients tidak perlu menampilkan layar consent.
 * Didaftarkan via Passport::useClientModel() di AuthServiceProvider.
 */
class Client extends PassportClient
{
    /**
     * Skip layar persetujuan (consent) untuk client trusted.
     */
    public function skipsAuthorization()
    {
        try {
            return (bool) optional(
                SsoClient::where('oauth_client_id', $this->getKey())->first()
            )->trusted;
        } catch (\Throwable $e) {
            // Aman saat migrasi/tabel belum ada: jangan skip consent.
            return false;
        }
    }
}
