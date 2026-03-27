<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdResign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_resign', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->date('tgl_eff_resign');
            $table->text('alasan_resign');
            $table->string('approval_key', 200);
            $table->integer('create_by');
            $table->integer('current_approval_id');
            $table->integer('is_draft'); //1: draff, 2: application
            $table->integer('sts_pengajuan'); //1: draff, 2: application
            $table->integer('cara_keluar')->nullable(); //1. Terhormat, 2. Tidak terhormat
            $table->string('nomor_skk', 50)->nullable();
            $table->date('tgl_skk')->nullable();
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
        Schema::dropIfExists('hrd_resign');
    }
}
