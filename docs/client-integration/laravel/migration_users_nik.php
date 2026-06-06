<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contoh skema user lokal ESS untuk SSO.
 * - NIK adalah kunci sinkron dari SSB (unik).
 * - Tidak ada kolom password (login via SSB), tapi boleh dipertahankan
 *   bila ESS masih punya login lokal lama.
 *
 * Jika tabel users ESS sudah ada, cukup tambahkan kolom `nik` (unik) saja.
 */
class CreateUsersTableForSso extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();      // kunci identitas dari SSB
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

/*
 | Bila users ESS SUDAH ada, pakai migrasi penambahan kolom seperti ini:
 |
 | Schema::table('users', function (Blueprint $table) {
 |     $table->string('nik')->nullable()->unique()->after('id');
 | });
 */
