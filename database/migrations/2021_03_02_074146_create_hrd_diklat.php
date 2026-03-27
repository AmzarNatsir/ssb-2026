<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdDiklat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_diklat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer("id_pelaksana")->unsigned();
            $table->foreign("id_pelaksana")->references("id")->on("mst_hrd_pelaksana_diklat");
            $table->string("nama_diklat", 200)->nullable();
            $table->date("tgl_mulai")->nullable();
            $table->date("tgl_selesai")->nullable();
            $table->double("biaya")->nullable();
            $table->string("tempat", 200)->nullable();
            $table->integer("status")->nullable();
            $table->string("nilai", 10)->nullable();
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
        Schema::dropIfExists('hrd_diklat');
    }
}
