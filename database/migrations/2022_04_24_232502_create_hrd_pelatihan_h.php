<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPelatihanH extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pelatihan_h', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->integer("id_pelatihan")->unsigned();
            $table->foreign("id_pelatihan")->references("id")->on("mst_hrd_pelatihan");
            $table->integer("id_pelaksana")->unsigned();
            $table->foreign("id_pelaksana")->references("id")->on("mst_hrd_pelaksana_diklat");
            $table->string('hari_awal', 20);
            $table->string('hari_sampai', 20)->nullable();
            $table->date('tanggal_awal');
            $table->date('tanggal_sampai')->nullable();
            $table->time('pukul_awal');
            $table->time('pukul_sampai');
            $table->string('tempat_pelaksanaan', 200)->nullable();
            $table->integer('id_ttd')->nullable();
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
        Schema::dropIfExists('hrd_pelatihan_h');
    }
}
