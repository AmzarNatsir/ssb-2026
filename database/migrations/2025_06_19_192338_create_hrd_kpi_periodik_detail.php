<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKpiPeriodikDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_kpi_periodik_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('id_head');
            $table->integer('id_kpi');
            $table->text('nama_kpi')->nullable();
            $table->string('tipe', 50)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->float('bobot')->nullable();
            $table->float('target')->nullable();
            $table->float('realisasi')->nullable();
            $table->float('skor_akhir')->nullable();
            $table->float('nilai_kpi')->nullable();
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
        Schema::dropIfExists('hrd_kpi_periodik_detail');
    }
}
