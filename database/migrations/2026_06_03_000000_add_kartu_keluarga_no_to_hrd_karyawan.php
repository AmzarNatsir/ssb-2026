<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKartuKeluargaNoToHrdKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            $table->string('kartu_keluarga_no', 50)->nullable();
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
            $table->dropColumn('kartu_keluarga_no');
        });
    }
}