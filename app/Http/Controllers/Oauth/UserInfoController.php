<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Endpoint userinfo SSO — mengembalikan IDENTITAS saja (tanpa role detail).
 * Dilindungi guard 'oauth' (driver passport) → butuh access token Passport.
 *
 * Kontrol akses TERPUSAT di SSB: user WAJIB memiliki role untuk bisa masuk
 * SSO. Aturan ini sudah ditegakkan saat login (LoginController), dan ditegakkan
 * lagi di sini sebagai pengaman berlapis (mis. role dicabut setelah token terbit).
 * Konsekuensinya: punya role di SSB = berhak akses ESS & seluruh client lain.
 */
class UserInfoController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();          // di-resolve via guard oauth

        // Gate akses terpusat: tanpa role tidak boleh masuk client mana pun.
        $isSuperAdmin = $user->nik === '999999999';
        if (! $isSuperAdmin && $user->roles->isEmpty()) {
            return response()->json([
                'error'   => 'access_denied',
                'message' => 'Akun tidak memiliki role akses. Hubungi administrator.',
            ], 403);
        }

        $karyawan = $user->karyawan;       // relasi hasOne KaryawanModel (hrd_karyawan)

        return response()->json([
            'sub'       => (string) $user->nik,     // identitas universal antar app
            'nik'       => $user->nik,
            'name'      => $karyawan->nm_lengkap ?? null,
            'email'     => $karyawan->nmemail ?? ($user->email ?? null),
            'is_active' => $karyawan ? is_null($karyawan->tgl_resign) : true,
        ]);
    }
}
