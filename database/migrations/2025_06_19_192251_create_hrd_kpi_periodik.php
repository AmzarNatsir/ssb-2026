<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKpiPeriodik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_kpi_periodik', function (Blueprint $table) {
            $table->id();
            $table->integer('id_departemen');
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->string('status', 50);
            $table->float('total_kpi')->nullable();
            $table->integer('user_created');
            $table->date('submit_at')->nullable();
            $table->integer('user_submit')->nullable();
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
        Schema::dropIfExists('hrd_kpi_periodik');
    }
}
