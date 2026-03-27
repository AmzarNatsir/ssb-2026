<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdThrDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_thr_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head');
            $table->integer('id_karyawan');
            $table->integer('id_departemen')->nullable();
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->double('gaji_pokok')->nullable();
            $table->double('tunj_tetap')->nullable();
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
        Schema::dropIfExists('hrd_thr_detail');
    }
}
