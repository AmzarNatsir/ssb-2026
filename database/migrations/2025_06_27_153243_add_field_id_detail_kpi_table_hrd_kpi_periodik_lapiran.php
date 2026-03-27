<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIdDetailKpiTableHrdKpiPeriodikLapiran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_kpi_periodik_lampiran', function (Blueprint $table) {
            $table->integer('id_detail_kpi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_kpi_periodik_lampiran', function (Blueprint $table) {
            //
        });
    }
}
