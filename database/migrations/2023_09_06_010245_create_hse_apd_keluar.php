<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseApdKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_apd_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no_register')->nullable();
            $table->integer('id_project')->unsigned();
            $table->integer('id_apd')->unsigned();
            $table->integer('id_karyawan_peminjam')->unsigned();
            $table->integer('id_karyawan_menyerahkan')->unsigned();
            $table->tinyInteger('qty_out')->unsigned();
            $table->date('tanggal_keluar');
            $table->string('keterangan');
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
        Schema::dropIfExists('hse_apd_keluar');
    }
}
