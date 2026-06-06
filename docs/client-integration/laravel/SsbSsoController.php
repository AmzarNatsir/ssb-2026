<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;                       // sesuaikan namespace User di ESS (App\User di Laravel 8)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * SSO client (ESS) ke Identity Provider SSB.
 * Alur: OAuth2 Authorization Code + PKCE.
 *
 * Pasang di app CLIENT (ESS), BUKAN di SSB.
 */
class SsbSsoController extends Controller
{
    /**
     * Mulai login: arahkan ke SSB /oauth/authorize dengan PKCE + state.
     */
    public function redirectToProvider(Request $request)
    {
        $verifier  = Str::random(64);
        $state     = Str::random(40);
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        $request->session()->put('ssb_code_verifier', $verifier);
        $request->session()->put('ssb_state', $state);

        $query = http_build_query([
            'client_id'             => config('services.ssb.client_id'),
            'redirect_uri'          => config('services.ssb.redirect'),
            'response_type'         => 'code',
            'scope'                 => '',
            'state'                 => $state,
            'code_challenge'        => $challenge,
            'code_challenge_method' => 'S256',
        ]);

        return redirect(config('services.ssb.base_url') . '/oauth/authorize?' . $query);
    }

    /**
     * Callback: tukar code -> token, ambil identitas, login user lokal.
     */
    public function handleCallback(Request $request)
    {
        // 1) Validasi state (anti-CSRF)
        $expectedState = $request->session()->pull('ssb_state');
        if (! $expectedState || ! hash_equals($expectedState, (string) $request->input('state'))) {
            abort(403, 'State tidak valid.');
        }

        if ($request->filled('error')) {
            abort(403, 'Otorisasi ditolak: ' . $request->input('error'));
        }

        $verifier = $request->session()->pull('ssb_code_verifier');

        // 2) Tukar authorization code -> access token
        $payload = [
            'grant_type'    => 'authorization_code',
            'client_id'     => config('services.ssb.client_id'),
            'redirect_uri'  => config('services.ssb.redirect'),
            'code_verifier' => $verifier,
            'code'          => $request->input('code'),
        ];
        // Client confidential: sertakan secret. Public/PKCE: biarkan kosong.
        if ($secret = config('services.ssb.client_secret')) {
            $payload['client_secret'] = $secret;
        }

        $tokenResp = Http::asForm()->post(config('services.ssb.base_url') . '/oauth/token', $payload);

        if ($tokenResp->failed()) {
            abort(401, 'Gagal menukar token: ' . $tokenResp->body());
        }

        $tokens      = $tokenResp->json();
        $accessToken = $tokens['access_token'] ?? null;
        if (! $accessToken) {
            abort(401, 'Access token kosong.');
        }

        // 3) Ambil identitas (tanpa role) dari SSB
        $userResp = Http::withToken($accessToken)
            ->acceptJson()
            ->get(config('services.ssb.base_url') . '/api/oauth/userinfo');

        if ($userResp->failed()) {
            abort(401, 'Gagal ambil userinfo.');
        }

        $info = $userResp->json();

        // Tolak karyawan nonaktif
        if (isset($info['is_active']) && $info['is_active'] === false) {
            abort(403, 'Akun karyawan nonaktif.');
        }

        // 4) Find-or-create user lokal berdasar NIK
        $user = User::firstOrCreate(
            ['nik' => $info['nik']],
            ['name' => $info['name'] ?? $info['nik']]
        );

        // Selalu sinkron nama terbaru (snapshot dari SSB)
        if (! empty($info['name']) && $user->name !== $info['name']) {
            $user->update(['name' => $info['name']]);
        }

        // (opsional) simpan token untuk panggilan API ke SSB berikutnya
        $request->session()->put('ssb_tokens', [
            'access_token'  => $accessToken,
            'refresh_token' => $tokens['refresh_token'] ?? null,
            'expires_in'    => $tokens['expires_in'] ?? null,
        ]);

        // 5) Tetapkan ROLE LOKAL ESS (kebijakan ESS, bukan dari SSB)
        $this->mapLocalRole($user, $info);

        // 6) Login & masuk aplikasi
        Auth::login($user, true);

        return redirect()->intended('/home');
    }

    /**
     * Logout lokal ESS. (Single Logout terpusat = Tahap 5.)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Kebijakan role LOKAL ESS. SESUAIKAN dengan kebutuhan ESS.
     *
     * Contoh memakai Spatie Permission:
     *   if ($user->roles->isEmpty()) {
     *       // Opsi A: auto-assign role default
     *       $user->assignRole('ess-user');
     *       // Opsi B: tolak sampai admin ESS memberi akses
     *       // abort(403, 'Akses ESS belum diberikan. Hubungi admin ESS.');
     *   }
     */
    protected function mapLocalRole(User $user, array $info): void
    {
        // TODO: implementasi sesuai kebijakan ESS.
    }
}
