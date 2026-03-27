<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nik_auto')->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('nm_lengkap', 200)->nullable();
            $table->string('tmp_lahir', 200)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->integer('jenkel')->nullable();
            $table->string('no_ktp', 50)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('notelp', 50)->nullable();
            $table->string('nmemail', 100)->nullable();
            $table->string('suku', 200)->nullable();
            $table->integer('agama')->nullable();
            $table->integer('pendidikan_akhir')->nullable();
            $table->integer('status_nikah')->nullable();
            $table->string('no_npwp', 50)->nullable();
            $table->string('no_bpjstk', 50)->nullable();
            $table->string('no_bpjsks', 50)->nullable();
            $table->string('photo', 50)->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->integer('id_divisi')->nullable();
            $table->integer('id_departemen')->nullable();
            $table->integer('id_subdepartemen')->nullable();
            $table->integer('id_jabatan')->nullable();
            $table->integer('id_status_karyawan')->nullable();
            $table->date('tgl_sts_efektif_mulai')->nullable();
            $table->date('tgl_sts_efektif_akhir')->nullable();
            $table->double('gaji_pokok')->nullable();
            $table->double('tunjangan')->nullable();
            $table->integer('id_bank')->nullable();
            $table->string('no_rekening', 50)->nullable();
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
        Schema::dropIfExists('hrd_karyawan');
    }
}
