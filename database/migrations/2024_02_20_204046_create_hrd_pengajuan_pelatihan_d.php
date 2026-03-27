<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPengajuanPelatihanD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pengajuan_pelatihan_d', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head')->unsigned();
            $table->foreign('id_head')->references('id')->on('hrd_pengajuan_pelatihan_h');
            $table->integer('id_pelatihan')->unsigned();
            $table->foreign('id_pelatihan')->references('id')->on('hrd_pelatihan_h');
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
        Schema::dropIfExists('hrd_pengajuan_pelatihan_d');
    }
}
