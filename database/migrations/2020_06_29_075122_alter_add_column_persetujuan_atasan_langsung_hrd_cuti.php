<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnPersetujuanAtasanLangsungHrdCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_cuti', function (Blueprint $table) {
            $table->integer('id_atasan')->nullable();
            $table->date('tgl_appr_atasan')->nullable();
            $table->integer('sts_appr_atasan')->nullable();
            $table->text('ket_appr_atasan')->nullable();
            $table->integer('id_pengganti')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_cuti', function (Blueprint $table) {
            //
        });
    }
}
