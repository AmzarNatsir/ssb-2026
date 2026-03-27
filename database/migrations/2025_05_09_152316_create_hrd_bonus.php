<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdBonus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_karyawan');
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->double('gaji_pokok')->nullable();
            $table->double('bonus')->nullable();
            $table->double('lembur')->nullable();
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
        Schema::dropIfExists('hrd_bonus');
    }
}
