<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldNomorSuratTableHrdCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_cuti', function (Blueprint $table) {
            $table->string('nomor_surat', 20)->nullable();
            $table->date('tanggal_surat')->nullable();
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
