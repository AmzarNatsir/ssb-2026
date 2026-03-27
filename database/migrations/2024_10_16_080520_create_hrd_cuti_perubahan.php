<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdCutiPerubahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_cuti_perubahan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_head');
            $table->date('tgl_akhir_edit');
            $table->integer('jumlah_hari_edit');
            $table->text('alasan_perubahan');
            $table->date('tgl_awal_origin');
            $table->date('tgl_akhir_origin');
            $table->integer('jumlah_hari_origin');
            $table->string('approval_key', 200);
            $table->integer('create_by');
            $table->integer('current_approval_id');
            $table->integer('is_draft'); //1: draff, 2: application
            $table->integer('sts_pengajuan'); //1: draff, 2: application
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
        Schema::dropIfExists('hrd_cuti_perubahan');
    }
}
