<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Metadata aplikasi client SSO (ESS, Warehouse, dst).
 * Tabel ini MELENGKAPI oauth_clients (bawaan Passport), bukan menggantikan:
 * - oauth_clients menyimpan kredensial OAuth (secret, redirect).
 * - sso_clients menyimpan metadata + flag operasional (aktif, trusted).
 * Bersifat additive; tidak menyentuh tabel existing.
 */
class CreateSsoClientsTable extends Migration
{
    public function up()
    {
        Schema::create('sso_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oauth_client_id');
            $table->string('name');
            $table->string('slug', 50)->nullable();          // kunci app, mis. 'ess', 'warehouse'
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('trusted')->default(false);        // true = skip layar consent (first-party)
            $table->timestamps();

            $table->unique('oauth_client_id');
            $table->foreign('oauth_client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sso_clients');
    }
}
