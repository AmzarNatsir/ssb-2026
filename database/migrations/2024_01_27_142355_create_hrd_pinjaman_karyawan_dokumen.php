<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPinjamanKaryawanDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pinjaman_karyawan_dokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head')->unsigned();
            $table->foreign('id_head')->references('id')->on('hrd_pinjaman_karyawan');
            $table->string('file_dokumen');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('hrd_pinjaman_karyawan_dokumen');
    }
}
