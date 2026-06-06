<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use App\Models\SsoClient;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;

/**
 * Admin panel kelola aplikasi client SSO.
 * Setiap aksi menyinkronkan oauth_clients (kredensial Passport) + sso_clients (metadata).
 * Akses dibatasi gate 'manage-sso' (lihat AuthServiceProvider).
 */
class SsoClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage-sso']);
    }

    public function index()
    {
        $clients = SsoClient::with('oauthClient')->latest()->get();

        return view('sso.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('sso.clients.create');
    }

    public function store(Request $request, ClientRepository $clients)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:191',
            'slug'        => 'nullable|string|max:50',
            'redirect'    => 'required|url',
            'description' => 'nullable|string',
        ]);

        $public = $request->boolean('public');

        // Buat kredensial OAuth. confidential = !public (public = PKCE, tanpa secret).
        $client = $clients->create(null, $data['name'], $data['redirect'], null, false, false, ! $public);

        SsoClient::create([
            'oauth_client_id' => $client->getKey(),
            'name'            => $data['name'],
            'slug'            => $data['slug'] ?? null,
            'description'     => $data['description'] ?? null,
            'is_active'       => $request->boolean('is_active', true),
            'trusted'         => $request->boolean('trusted'),
        ]);

        $flash = redirect()->route('sso.clients.index')
            ->with('success', 'Client SSO berhasil dibuat.')
            ->with('new_client_id', $client->getKey());

        // Secret confidential hanya ditampilkan sekali di sini.
        if (! $public) {
            $flash->with('new_client_secret', $client->plainSecret);
        }

        return $flash;
    }

    public function edit(SsoClient $ssoClient)
    {
        $ssoClient->load('oauthClient');

        return view('sso.clients.edit', compact('ssoClient'));
    }

    public function update(Request $request, SsoClient $ssoClient, ClientRepository $clients)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:191',
            'slug'        => 'nullable|string|max:50',
            'redirect'    => 'required|url',
            'description' => 'nullable|string',
        ]);

        $oauth = $clients->find($ssoClient->oauth_client_id);
        if ($oauth) {
            $clients->update($oauth, $data['name'], $data['redirect']);
        }

        $ssoClient->update([
            'name'        => $data['name'],
            'slug'        => $data['slug'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active'   => $request->boolean('is_active'),
            'trusted'     => $request->boolean('trusted'),
        ]);

        return redirect()->route('sso.clients.index')->with('success', 'Client SSO diperbarui.');
    }

    public function destroy(SsoClient $ssoClient, ClientRepository $clients)
    {
        $oauth = $clients->find($ssoClient->oauth_client_id);
        if ($oauth) {
            // Revoke token & hapus kredensial OAuth (cascade akan ikut hapus sso_clients).
            $clients->delete($oauth);
        }
        $ssoClient->delete();

        return redirect()->route('sso.clients.index')
            ->with('success', 'Client SSO dihapus & seluruh token-nya direvoke.');
    }
}
