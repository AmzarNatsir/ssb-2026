<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrNilaiWawancara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_nilai_wawancara', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pelamar')->unsigned();
            $table->foreign('id_pelamar')->references('id')->on('hrd_recr_pelamar');
            $table->integer('kriteria_1');
            $table->integer('kriteria_2');
            $table->integer('kriteria_3');
            $table->integer('kriteria_4');
            $table->integer('kriteria_5');
            $table->integer('kriteria_6');
            $table->integer('kriteria_7');
            $table->integer('kriteria_8');
            $table->integer('kriteria_9');
            $table->integer('kriteria_10');
            $table->integer('kriteria_11');
            $table->integer('kriteria_12');
            $table->integer('kriteria_13');
            $table->integer('kriteria_14');
            $table->integer('kriteria_15');
            $table->integer('total_rating');
            $table->enum('hasil', ['Dapat Disarankan', 'Dipertimbangakan', 'Tidak Disarankan']);
            $table->text('saran_komentar')->nullable();
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
        Schema::dropIfExists('hrd_recr_nilai_wawancara');
    }
}
