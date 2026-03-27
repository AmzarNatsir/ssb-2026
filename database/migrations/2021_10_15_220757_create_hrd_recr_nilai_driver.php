<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrNilaiDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_nilai_driver', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pelamar')->unsigned();
            $table->foreign('id_pelamar')->references('id')->on('hrd_recr_pelamar');
            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->integer('nilai_6')->nullable();
            $table->integer('nilai_7')->nullable();
            $table->integer('nilai_8')->nullable();
            $table->integer('nilai_9')->nullable();
            $table->integer('nilai_10')->nullable();
            $table->integer('nilai_11')->nullable();
            $table->integer('nilai_12')->nullable();
            $table->integer('nilai_13')->nullable();
            $table->integer('nilai_14')->nullable();
            $table->integer('nilai_15')->nullable();
            $table->integer('nilai_16')->nullable();
            $table->integer('nilai_17')->nullable();
            $table->integer('nilai_18')->nullable();
            $table->integer('nilai_19')->nullable();
            $table->text('catatan_1')->nullable();
            $table->text('catatan_2')->nullable();
            $table->text('catatan_3')->nullable();
            $table->text('catatan_4')->nullable();
            $table->text('catatan_5')->nullable();
            $table->text('catatan_6')->nullable();
            $table->text('catatan_7')->nullable();
            $table->text('catatan_8')->nullable();
            $table->text('catatan_9')->nullable();
            $table->text('catatan_10')->nullable();
            $table->text('catatan_11')->nullable();
            $table->text('catatan_12')->nullable();
            $table->text('catatan_13')->nullable();
            $table->text('catatan_14')->nullable();
            $table->text('catatan_15')->nullable();
            $table->text('catatan_16')->nullable();
            $table->text('catatan_17')->nullable();
            $table->text('catatan_18')->nullable();
            $table->text('catatan_19')->nullable();
            $table->enum('hasil', ['Lulus', 'Tidak Lulus']);
            $table->text('komentar')->nullable();
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
        Schema::dropIfExists('hrd_recr_nilai_driver');
    }
}
