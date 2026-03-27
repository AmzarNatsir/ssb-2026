<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHsePerusahaanAngkutansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hse_perusahaan_angkutan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable()->unique();
            $table->string('nama_pimpinan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_kontak')->nullable();
            $table->boolean('is_active')->default(true)->comment('1=aktif 2=non aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_hse_perusahaan_angkutans');
    }
}
