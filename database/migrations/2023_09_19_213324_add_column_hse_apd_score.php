<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHseApdScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_apd_score', function (Blueprint $table) {
            $table->json("item_penilaian")->nullable()->after("id_karyawan");
            $table->date("tgl_penilaian")->nullable()->after("id_karyawan");
            $table->integer("id_apd")->nullable()->after("id_karyawan");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_apd_score', function (Blueprint $table) {
            $table->dropColumn("id_apd");
            $table->dropColumn("item_penilaian");
            $table->dropColumn("tgl_penilaian");
        });
    }
}
