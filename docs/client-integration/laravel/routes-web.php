<?php

/**
 * Salin route ini ke routes/web.php milik ESS.
 * Path callback HARUS sama dengan redirect URI yang didaftarkan di SSB.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SsbSsoController;

// Tombol "Login dengan SSB" mengarah ke sini
Route::get('/auth/ssb/redirect', [SsbSsoController::class, 'redirectToProvider'])->name('ssb.redirect');

// Callback dari SSB setelah otorisasi
Route::get('/auth/ssb/callback', [SsbSsoController::class, 'handleCallback'])->name('ssb.callback');

// Logout lokal ESS
Route::post('/auth/ssb/logout', [SsbSsoController::class, 'logout'])->name('ssb.logout');

/*
 | Opsional: paksa semua halaman butuh login via SSB.
 | Buat middleware yang redirect guest ke route('ssb.redirect'),
 | atau ubah Authenticate middleware ESS:
 |
 |   protected function redirectTo($request) {
 |       return route('ssb.redirect');
 |   }
 */
