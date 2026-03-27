<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsIdKaryawanNoSafetyInduksiInHrdRecrPelamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            $table->integer('id_karyawan')->nullable();
            $table->string('no_surat_si', 50)->nullable();
            $table->date('tgl_surat_si')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            //
        });
    }
}
