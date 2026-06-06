<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        // === SSO (Identity Provider) — Tahap 2 ===
        // Daftarkan endpoint OAuth2 Passport: /oauth/authorize, /oauth/token, dll.
        // Route ini terpisah dari route web/api existing — tidak mengganggu yang sudah ada.
        // /oauth/authorize otomatis pakai middleware [web, auth] sehingga user yang belum
        // login akan diarahkan ke halaman login existing (LoginController), lalu kembali.
        Passport::routes();

        // Masa berlaku token (security: access token pendek + refresh token).
        Passport::tokensExpireIn(now()->addMinutes(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addDays(7));
    }
}
