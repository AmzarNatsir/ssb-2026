<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSpActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            $table->string('sp_active', 20)->nullable(); //aktif/tidak aktif
            $table->integer('sp_level_active')->nullable();
            $table->integer('sp_lama_active')->nullable();
            $table->date("sp_mulai_active")->nullable();
            $table->date('sp_akhir_active')->nullable();
            $table->date('sp_reff')->nullable();
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
