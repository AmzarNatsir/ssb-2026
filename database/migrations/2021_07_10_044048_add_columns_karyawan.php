<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            $table->string("nik_lama", 50)->nullable();
            $table->string("gol_darah", 10)->nullable();
            $table->string("status_lain", 10)->nullable();
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
            $table->dropColumn(['nik_lama', 'gol_darah', 'status_lain']);
        });
    }
}
