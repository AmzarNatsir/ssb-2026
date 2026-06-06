<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models\Passport\Client as SsoPassportClient;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\\Policies\\'.class_basename($modelClass).'Policy';
        });

        // === SSO (Identity Provider) — Tahap 3 ===
        // Pakai model Client kustom agar client "trusted" (first-party) bisa skip consent.
        Passport::useClientModel(SsoPassportClient::class);

        // Daftarkan HANYA endpoint yang diperlukan: authorize, token, refresh.
        // Sengaja TIDAK mendaftarkan forClients() & forPersonalAccessTokens() bawaan
        // Passport (/oauth/clients, /oauth/personal-access-tokens) karena mengizinkan
        // user mengelola client OAuth sendiri — manajemen client kita tangani via admin
        // panel sso.clients (gate 'manage-sso'). Tahap 2: /oauth/authorize pakai
        // middleware [web, auth] → reuse halaman login existing.
        Passport::routes(function ($router) {
            $router->forAuthorization();
            $router->forAccessTokens();
            $router->forTransientTokens();
        });

        // Masa berlaku token (security: access token pendek + refresh token).
        Passport::tokensExpireIn(now()->addMinutes(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addDays(7));

        // Hanya super admin yang boleh mengelola aplikasi client SSO.
        Gate::define('manage-sso', function ($user) {
            return $user->nik === '999999999'
                || $user->hasAnyRole(['super_admin', 'Super Admin']);
        });
    }
}
