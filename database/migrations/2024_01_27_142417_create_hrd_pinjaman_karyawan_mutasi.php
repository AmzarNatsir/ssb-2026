<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPinjamanKaryawanMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pinjaman_karyawan_mutasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head')->unsigned();
            $table->foreign('id_head')->references('id')->on('hrd_pinjaman_karyawan');
            $table->date('tanggal')->nullable();
            $table->double('nominal');
            $table->integer('status')->nullable();
            $table->integer('bayar_aktif')->default(0);
            $table->string('bukti_bayar', 100)->nullable();
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
        Schema::dropIfExists('hrd_pinjaman_karyawan_mutasi');
    }
}
