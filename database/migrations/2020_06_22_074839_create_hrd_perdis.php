<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPerdis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_perdis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->string('no_perdis', 20)->nullable();
            $table->date('tgl_perdis')->nullable();
            $table->text('maksud_tujuan')->nullable();
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->integer('id_uangsaku')->nullable();
            $table->integer('id_fasilitas')->nullable();
            $table->text('ket_perdis')->nullable();
            $table->integer('id_user')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->integer('id_persetujuan')->nullable();
            $table->integer('sts_persetujuan')->nullable();
            $table->date('tgl_persetujuan')->nullable();
            $table->text('ket_persetujuan')->nullable();
            $table->integer('sts_pengajuan');
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
        Schema::dropIfExists('hrd_perdis');
    }
}
