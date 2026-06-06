<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;
use Laravel\Passport\RefreshToken;

/**
 * SSO Single Logout (Tahap 5) — front-channel.
 *
 * Alur:
 *   App client (ESS, dst) hapus session lokal
 *     -> redirect browser ke /sso/logout?redirect=<url client>
 *     -> SSB revoke token user + akhiri session IdP (web guard)
 *     -> redirect balik ke client (divalidasi anti open-redirect)
 *
 * Setelah ini, /oauth/authorize berikutnya tidak punya session IdP lagi sehingga
 * user wajib login NIK+password ulang (memungkinkan "ganti user").
 *
 * Catatan: endpoint GET tanpa CSRF (front-channel logout). Dampak terburuk hanya
 * "ter-logout", dan redirect dibatasi ke origin client yang terdaftar.
 */
class SsoLogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = Auth::user();

        // 1) Revoke seluruh token OAuth milik user ini (Single Logout).
        //    User model memakai HasApiTokens milik Sanctum, jadi token Passport
        //    di-revoke langsung lewat model Passport, bukan relasi $user->tokens().
        if ($user) {
            $tokenIds = Token::where('user_id', $user->getAuthIdentifier())
                ->where('revoked', false)
                ->pluck('id');

            if ($tokenIds->isNotEmpty()) {
                Token::whereIn('id', $tokenIds)->update(['revoked' => true]);
                RefreshToken::whereIn('access_token_id', $tokenIds)->update(['revoked' => true]);
            }
        }

        // 2) Akhiri session IdP (web guard).
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3) Redirect balik ke client, divalidasi terhadap whitelist origin.
        return redirect($this->safeRedirect($request->query('redirect')));
    }

    /**
     * Kembalikan URL redirect bila origin-nya cocok dengan origin redirect URI
     * salah satu client OAuth terdaftar; jika tidak, jatuh ke halaman login IdP.
     */
    protected function safeRedirect($redirect): string
    {
        if (! $redirect) {
            return url('/');
        }

        $origin = $this->originOf($redirect);
        if (! $origin) {
            return url('/');
        }

        $allowed = DB::table('oauth_clients')
            ->whereNotNull('redirect')
            ->pluck('redirect')
            ->flatMap(function ($r) {
                return explode(',', $r); // Passport bisa simpan banyak redirect (comma-separated)
            })
            ->map(function ($uri) {
                return $this->originOf(trim($uri));
            })
            ->filter()
            ->unique();

        return $allowed->contains($origin) ? $redirect : url('/');
    }

    /**
     * Ekstrak origin (scheme://host[:port]) dari sebuah URL.
     */
    protected function originOf($url): ?string
    {
        $p = parse_url((string) $url);
        if (empty($p['scheme']) || empty($p['host'])) {
            return null;
        }

        $origin = $p['scheme'] . '://' . $p['host'];
        if (! empty($p['port'])) {
            $origin .= ':' . $p['port'];
        }

        return $origin;
    }
}
