<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdKpiSasaranStrategi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_kpi_sasaran_strategi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sasaran_strategi', 200);
            $table->integer('active'); //1. Aktif, 2.Tidak Aktif
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
        Schema::dropIfExists('mst_hrd_kpi_sasaran_strategi');
    }
}
