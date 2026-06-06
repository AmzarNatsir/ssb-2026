<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Endpoint userinfo SSO — mengembalikan IDENTITAS saja (tanpa role).
 * Role/otorisasi dikelola lokal di tiap app client (ESS, Warehouse).
 * Dilindungi guard 'oauth' (driver passport) → butuh access token Passport.
 */
class UserInfoController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();          // di-resolve via guard oauth
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
