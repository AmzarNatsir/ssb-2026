<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseP2hTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_p2h', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis_p2h')->nullable();
            $table->json('kategori_kendaraan')->nullable();
            $table->string('no_unit')->nullable();
            $table->date('tgl_inspeksi')->nullable();
            $table->integer('hm_awal')->nullable();
            $table->integer('hm_akhir')->nullable();
            $table->string('lokasi')->nullable();
            $table->json('pelaksana')->nullable();
            $table->json('penanggung_jawab_unit')->nullable();
            $table->json('safety_officer')->nullable();
            $table->string('form_file')->nullable();
            $table->json('penggantian_alat_keselamatan')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('hse_p2h');
    }
}
