<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdKpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_kpi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_departemen")->unsigned();
            $table->foreign("id_departemen")->references("id")->on("mst_hrd_departemen");
            $table->integer("id_tipe")->unsigned();
            $table->foreign("id_tipe")->references("id")->on("mst_hrd_kpi_tipe");
            $table->integer("id_satuan")->unsigned();
            $table->foreign("id_satuan")->references("id")->on("mst_hrd_kpi_satuan");
            $table->text('nama_kpi');
            $table->text('formula_hitung')->nullable();
            $table->text('data_pendukung')->nullable();
            $table->integer('bobot_kpi');
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
        Schema::dropIfExists('mst_hrd_kpi');
    }
}
