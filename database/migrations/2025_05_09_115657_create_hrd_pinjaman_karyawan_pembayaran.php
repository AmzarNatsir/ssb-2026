<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPinjamanKaryawanPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pinjaman_karyawan_pembayaran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head');
            $table->date('tanggal');
            $table->double('nominal');
            $table->integer('id_user');
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
        Schema::dropIfExists('hrd_pinjaman_karyawan_pembayaran');
    }
}
