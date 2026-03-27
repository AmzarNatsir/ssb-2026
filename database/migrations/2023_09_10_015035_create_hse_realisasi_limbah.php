<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseRealisasiLimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_realisasi_limbah', function (Blueprint $table) {
            $table->id();
            $table->integer('id_plan_limbah')->nullable();
            $table->integer('id_limbah')->nullable();
            $table->integer('id_prsh_jasa_angkutan')->nullable();
            $table->date('tgl_realisasi')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->double('sub_total', 18, 2)->nullable();
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
        Schema::dropIfExists('hse_realisasi_limbah');
    }
}
