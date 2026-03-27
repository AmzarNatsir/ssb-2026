<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnJumlahHariHrdCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_cuti', function (Blueprint $table) {
            $table->integer('jumlah_hari')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->integer('jumlah_quota')->nullable();
            $table->integer('quota_terpakai')->nullable();
            $table->integer('sisa_quota')->nullable();
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
