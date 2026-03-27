<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseJobSafetyAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_job_safety_analisis', function (Blueprint $table) {
            $table->id();
            $table->string('no_jsa', 100)->nullable();
            $table->string('no_dokumen', 100)->nullable();
            $table->string('nama_pengawas', 150)->nullable();
            $table->string('nama_pelaksana', 150)->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->date('tanggal_terbit', 100)->nullable();
            $table->string('nama_apd', 150)->nullable();
            $table->string('file_jsa', 150)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('hse_job_safety_analisis');
    }
}
