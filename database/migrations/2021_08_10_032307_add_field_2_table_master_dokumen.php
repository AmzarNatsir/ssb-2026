<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddField2TableMasterDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_hrd_jenis_dokumen_karyawan', function (Blueprint $table) {
            $table->integer("karyawan")->nullable();
            $table->integer("pelamar")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_hrd_jenis_dokumen_karyawan', function (Blueprint $table) {
            //
        });
    }
}
