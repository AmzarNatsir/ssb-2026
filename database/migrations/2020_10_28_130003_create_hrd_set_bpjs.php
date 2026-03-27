<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdSetBpjs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_set_bpjs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('jht_karyawan')->nullable();
            $table->float('jht_perusahaan')->nullable();
            $table->float('jkk_karyawan')->nullable();
            $table->float('jkk_perusahaan')->nullable();
            $table->float('jkm_karyawan')->nullable();
            $table->float('jkm_perusahaan')->nullable();
            $table->float('jp_karyawan')->nullable();
            $table->float('jp_perusahaan')->nullable();
            $table->float('bpjsks_karyawan')->nullable();
            $table->float('bpjsks_perusahaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrd_set_bpjs');
    }
}
