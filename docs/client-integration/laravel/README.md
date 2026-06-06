# Integrasi SSO SSB — Panduan Client (Laravel)

Panduan + kode siap-tempel agar aplikasi **ESS** (atau Warehouse, dst) login
lewat SSO SSB. Pola: **OAuth2 Authorization Code + PKCE**. Tidak butuh paket
tambahan — cukup HTTP client bawaan Laravel.

> Sisi SSB (IdP) sudah siap: endpoint `/oauth/authorize`, `/oauth/token`, dan
> `/api/oauth/userinfo` aktif. Client dev "ESS (dev)" sudah terdaftar
> (`client_id=1`, public/PKCE, trusted, redirect `http://localhost:8001/auth/ssb/callback`).
> Untuk produksi, buat client baru lewat admin panel SSB `/admin/sso/clients`.

---

## Ringkas alur

```
ESS /login  ──redirect──▶  SSB /oauth/authorize (+PKCE,state)
                            └─ user login di SSB (sekali) → setuju (skip jika trusted)
ESS /auth/ssb/callback  ◀── code+state
ESS  ──POST /oauth/token (code+code_verifier)──▶ SSB  → access_token
ESS  ──GET /api/oauth/userinfo (Bearer)──▶ SSB  → {nik, name, email, is_active}
ESS  find-or-create user by NIK → set ROLE LOKAL ESS → login → /home
```

Role **tidak** datang dari SSB — ESS menetapkan role lokalnya sendiri berdasar NIK.

---

## Langkah pemasangan di ESS

### 1. ENV (`.env`)

Lihat [`env.example.txt`](env.example.txt). Tambahkan:

```env
SSB_BASE_URL=http://localhost:8000
SSB_CLIENT_ID=1
SSB_CLIENT_SECRET=
SSB_REDIRECT_URI=http://localhost:8001/auth/ssb/callback
```

> Client public/PKCE → `SSB_CLIENT_SECRET` dikosongkan. Kalau pakai client
> confidential, isi secret-nya (dari admin panel SSB, ditampilkan sekali).

### 2. Config

Tambahkan blok di [`config-services.php`](config-services.php) ke
`config/services.php` ESS.

### 3. Routes

Salin isi [`routes-web.php`](routes-web.php) ke `routes/web.php` ESS.

### 4. Controller

Salin [`SsbSsoController.php`](SsbSsoController.php) ke
`app/Http/Controllers/Auth/` di ESS.

### 5. Tabel & model user lokal

- Jalankan migrasi contoh [`migration_users_nik.php`](migration_users_nik.php)
  (pastikan kolom `nik` unik). Sesuaikan bila ESS sudah punya tabel users.
- Pastikan `App\Models\User` punya `nik` di `$fillable`.

### 6. Mapping role lokal

Di method `mapLocalRole()` controller, tentukan kebijakan ESS:
- auto-assign role default, **atau**
- tolak user yang belum diberi akses oleh admin ESS.

### 7. Daftarkan redirect URI di SSB

Pastikan `SSB_REDIRECT_URI` **sama persis** dengan redirect URI client di
admin panel SSB (`/admin/sso/clients`). Mismatch → ditolak (`invalid redirect`).

---

## Uji cepat (dev)

1. Jalankan SSB di `:8000`, ESS di `:8001`.
2. Buka ESS → klik "Login dengan SSB".
3. Login NIK+password di SSB → kembali ke ESS sudah ter-login.

---

## Keamanan (wajib)

- **PKCE** (`code_challenge_method=S256`) — sudah di controller.
- **`state`** divalidasi anti-CSRF — sudah di controller.
- **HTTPS** di produksi.
- Simpan `access_token`/`refresh_token` di server-side session ESS, jangan di
  cookie yang bisa dibaca JS.
- Validasi `is_active` dari userinfo — tolak karyawan nonaktif.

## Logout

Untuk sekarang ESS cukup **logout lokal**. Single Logout terpusat (SSB
`/sso/logout`) menyusul di Tahap 5 — lihat `docs/SSO_DESIGN.md`.
