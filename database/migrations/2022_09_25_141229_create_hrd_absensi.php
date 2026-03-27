<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_absensi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_departemen')->nullable();
            $table->integer('id_finger')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->string('status', 100)->nullable();
            $table->integer('lokasi_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('hrd_absensi');
    }
}
