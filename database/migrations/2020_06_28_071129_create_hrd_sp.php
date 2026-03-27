<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_sp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->string('no_sp', 20)->nullable();
            $table->date('tgl_sp')->nullable();
            $table->integer('id_jenis_sp_disetujui')->nullable();
            $table->text('uraian_pelanggaran')->nullable();
            $table->integer('id_pengajuan')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->integer('id_jenis_sp_pengajuan')->nullable();
            $table->integer('id_persetujuan')->nullable();
            $table->integer('sts_persetujuan')->nullable();
            $table->date('tgl_persetujuan')->nullable();
            $table->text('ket_persetujuan')->nullable();
            $table->integer('sts_pengajuan')->nullable();
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
        Schema::dropIfExists('hrd_sp');
    }
}
