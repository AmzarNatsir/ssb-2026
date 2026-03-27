<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsStatusSubmitHrdKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            $table->string('evaluasi_kerja', 20)->nullable(); //active/inactive
            $table->string('kategori_evaluasi_kerja', 50)->nullable(); //pkwt-kartab / mutasi
            $table->string('cuti', 20)->nullable(); //active/inactive
            $table->string('izin', 20)->nullable(); //active/inactive
            $table->string('pelatihan', 20)->nullable(); //active/inactive
            $table->string('perdis', 20)->nullable(); //active/inactive
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            //
        });
    }
}
