<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdPotonganGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_potongan_gaji', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_potongan', 100);
            $table->integer('status')->default(1); //1. Aktif, 2.Tidak Aktif
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
        Schema::dropIfExists('mst_hrd_potongan_gaji');
    }
}
