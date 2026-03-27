<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseSafetyInductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_safety_induction', function (Blueprint $table) {
            $table->id();
            $table->string('nik_karyawan', 50)->nullable();
            $table->string('file_surat_pengantar', 150)->nullable();
            $table->string('file_form_induksi', 150)->nullable();
            $table->string('file_dokumentasi_1', 150)->nullable();
            $table->string('file_dokumentasi_2', 150)->nullable();
            $table->string('file_dokumentasi_3', 150)->nullable();
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
        Schema::dropIfExists('hse_safety_induction');
    }
}
