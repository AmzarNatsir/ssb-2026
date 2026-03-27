<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseApdScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_apd_score', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->integer('id_karyawan')->unsigned();
            $table->string('score_apd')->nullable();
            $table->integer('score_apd_nilai')->unsigned()->nullable();
            $table->integer('score_pemahaman_kta')->unsigned()->nullable();
            $table->integer('score_pemahaman_tta')->unsigned()->nullable();
            $table->integer('score_perawatan_apd')->unsigned()->nullable();
            $table->integer('total_score')->unsigned()->nullable();
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
        Schema::dropIfExists('hse_apd_score');
    }
}
