<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPinjamanKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pinjaman_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on('hrd_karyawan');
            $table->date('tgl_pengajuan');
            $table->integer('kategori');
            $table->string('alasan_pengajuan', 100);
            $table->double('nominal_apply');
            $table->double('nominal_acc')->nullable();
            $table->integer('tenor_apply');
            $table->integer('tenor_acc')->nullable();
            $table->double('angsuran');
            $table->integer('status_pengajuan')->nullable();
            $table->string('aktif', 1); // y/n
            $table->string('approval_key', 200)->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable();
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
        Schema::dropIfExists('hrd_pinjaman_karyawan');
    }
}
