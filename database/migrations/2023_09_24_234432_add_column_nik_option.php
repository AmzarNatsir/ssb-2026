<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNikOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_safety_induction', function (Blueprint $table) {
            $table->json('nik_karyawan_opt')->nullable()->after('nik_karyawan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_safety_induction', function (Blueprint $table) {
            $table->dropColumn('nik_karyawan_opt');
        });
    }
}
