<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPerdisFasilitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_perdis_fasilitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_perdis")->unsigned();
            $table->foreign("id_perdis")->references("id")->on("hrd_perdis");
            $table->integer("id_fasilitas")->unsigned();
            $table->foreign("id_fasilitas")->references("id")->on("mst_hrd_fasilitas_perdis");
            $table->integer('hari')->nullable();
            $table->double('biaya')->nullable();
            $table->double('sub_total')->nullable();
            $table->string('file_1', 100)->nullable();
            $table->string('file_2', 100)->nullable();
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
        Schema::dropIfExists('hrd_perdis_fasilitas');
    }
}
