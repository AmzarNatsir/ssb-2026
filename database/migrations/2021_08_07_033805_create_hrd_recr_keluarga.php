<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrKeluarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_keluarga', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pelamar")->unsigned();
            $table->foreign("id_pelamar")->references("id")->on("hrd_recr_pelamar");
            $table->integer("id_hubungan");
            $table->string("nm_keluarga", 200);
            $table->string("tmp_lahir", 200)->nullable();
            $table->date("tgl_lahir")->nullable();
            $table->integer("jenkel");
            $table->integer("id_jenjang");
            $table->string("pekerjaan", 200)->nullable();
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
        Schema::dropIfExists('hrd_recr_keluarga');
    }
}
