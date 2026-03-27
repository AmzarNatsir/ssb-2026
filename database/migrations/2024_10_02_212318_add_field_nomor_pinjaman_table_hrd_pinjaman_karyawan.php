<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldNomorPinjamanTableHrdPinjamanKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_pinjaman_karyawan', function (Blueprint $table) {
            $table->string('nomor_pinjaman', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_pinjaman_karyawan', function (Blueprint $table) {
            //
        });
    }
}
