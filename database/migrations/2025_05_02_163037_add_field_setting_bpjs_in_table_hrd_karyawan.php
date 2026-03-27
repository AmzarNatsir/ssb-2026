<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSettingBpjsInTableHrdKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_karyawan', function (Blueprint $table) {
            $table->string('bpjs_kesehatan', 1)->nullable();
            $table->string('bpjs_tk_jht', 1)->nullable();
            $table->string('bpjs_tk_jkk', 1)->nullable();
            $table->string('bpjs_tk_jkm', 1)->nullable();
            $table->string('bpjs_tk_jp', 1)->nullable();
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
            //
        });
    }
}
