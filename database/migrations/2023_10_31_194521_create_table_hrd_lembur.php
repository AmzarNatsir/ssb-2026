<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHrdLembur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_lembur', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->date('tgl_pengajuan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('total_jam')->nullable();
            $table->text('deskripsi_pekerjaan');
            $table->text('keterangan')->nullable();
            $table->integer('status_pengajuan');
            $table->string('approval_key')->nullable();
            $table->integer('current_approval_id')->nullable();
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
        Schema::dropIfExists('hrd_lembur');
    }
}
