<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPengajuanPelatihanH extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pengajuan_pelatihan_h', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun', 4);
            $table->text('deskripsi');
            $table->string('approval_key')->nullable();
            $table->integer('status_pengajuan')->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable(); //1=default -> Masih bisa diedit; 2. Tidak bisa diedit;
            $table->integer('diajukan_oleh');
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
        Schema::dropIfExists('hrd_pengajuan_pelatihan_h');
    }
}
