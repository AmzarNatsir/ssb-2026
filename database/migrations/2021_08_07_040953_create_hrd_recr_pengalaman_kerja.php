<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrPengalamanKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_pengalaman_kerja', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pelamar")->unsigned();
            $table->foreign("id_pelamar")->references("id")->on("hrd_recr_pelamar");
            $table->string("nm_perusahaan", 200);
            $table->string("posisi", 200);
            $table->string("alamat", 200);
            $table->string("mulai_tahun", 4);
            $table->string("sampai_tahun", 4);
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
        Schema::dropIfExists('hrd_recr_pengalaman_kerja');
    }
}
