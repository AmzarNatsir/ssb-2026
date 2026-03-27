<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKpiPeriodikLampiran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_kpi_periodik_lampiran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_head');
            $table->string("keterangan", 100);
            $table->string('file_lampiran', 100);
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
        Schema::dropIfExists('hrd_kpi_periodik_lampiran');
    }
}
