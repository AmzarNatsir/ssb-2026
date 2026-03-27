<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdPelaksanaDiklat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_pelaksana_diklat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_lembaga', 150)->nullable();
            $table->string('alamat', 150)->nullable();
            $table->string('no_telepon', 50)->nullable();
            $table->string('nama_email', 150)->nullable();
            $table->string('kontak_person', 150)->nullable();
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
        Schema::dropIfExists('mst_hrd_pelaksana_diklat');
    }
}
