<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_dokumen', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pelamar")->unsigned();
            $table->foreign("id_pelamar")->references("id")->on("hrd_recr_pelamar");
            $table->string("file_dokumen", 50);
            $table->string("path_file", 200);
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
        Schema::dropIfExists('hrd_recr_dokumen');
    }
}
