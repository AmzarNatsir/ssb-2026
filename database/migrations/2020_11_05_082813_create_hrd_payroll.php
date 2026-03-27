<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_payroll', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->string("bulan", 2);
            $table->string("tahun", 4);
            $table->double("gaji_pokok");
            $table->double('tunj_perusahaan')->nullable();
            $table->double("tunj_tetap")->nullable();
            $table->double("hours_meter")->nullable();
            $table->double("bpjsks_karyawan")->nullable();
            $table->double("bpjstk_jht_karyawan")->nullable();
            $table->double("bpjstk_jp_karyawan")->nullable();
            $table->double("bpjstk_jkm_karyawan")->nullable();
            $table->double("bpjstk_jkk_karyawan")->nullable();
            $table->double("bpjsks_perusahaan")->nullable();
            $table->double("bpjstk_jht_perusahaan")->nullable();
            $table->double("bpjstk_jp_perusahaan")->nullable();
            $table->double("bpjstk_jkm_perusahaan")->nullable();
            $table->double("bpjstk_jkk_perusahaan")->nullable();
            $table->integer("cetak_slip")->nullable();
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
        Schema::dropIfExists('hrd_payroll');
    }
}
