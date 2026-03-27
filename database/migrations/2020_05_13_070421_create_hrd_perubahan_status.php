<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPerubahanStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_perubahan_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->string('no_surat', 50)->nullable();
            $table->date('tgl_surat')->nullable();
            $table->date('tgl_eff_lama')->nullable();
            $table->date('tgl_akh_lama')->nullable();
            $table->integer('id_sts_lama')->nullable();
            $table->date('tgl_eff_baru')->nullable();
            $table->date('tgl_akh_baru')->nullable();
            $table->integer('id_sts_baru')->nullable();
            $table->integer('no_auto')->nullable();
            $table->integer('id_ttd')->nullable();
            $table->integer('id_user')->nullable();
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
        Schema::dropIfExists('hrd_perubahan_status');
    }
}
