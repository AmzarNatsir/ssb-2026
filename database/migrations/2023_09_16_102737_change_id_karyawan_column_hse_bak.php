<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdKaryawanColumnHseBak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_bak', function (Blueprint $table) {
            $table->json('id_karyawan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_bak', function (Blueprint $table) {
            $table->integer('id_karyawan')->nullable()->change();
        });
    }
}
