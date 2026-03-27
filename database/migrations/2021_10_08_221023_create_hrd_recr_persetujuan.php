<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrPersetujuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_persetujuan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pelamar')->unsigned();
            $table->foreign('id_pelamar')->references('id')->on('hrd_recr_pelamar');
            $table->integer('hasil');
            $table->text('keterangan')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('tanggal_persetujuan')->nullable();
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
        Schema::dropIfExists('hrd_recr_persetujuan');
    }
}
