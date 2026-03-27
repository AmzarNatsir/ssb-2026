<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrPengajuanTk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_pengajuan_tk', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_pengajuan');
            $table->integer("id_departemen")->unsigned();
            $table->foreign("id_departemen")->references("id")->on("mst_hrd_departemen");
            $table->integer("id_jabatan")->unsigned();
            $table->foreign("id_jabatan")->references("id")->on("mst_hrd_jabatan");
            $table->integer('jumlah_orang');
            $table->date('tanggal_dibutuhkan');
            $table->string('alasan_permintaan', 100)->nullable();
            $table->integer('jenkel')->nullable();
            $table->integer('umur_min')->nullable();
            $table->integer('umur_maks')->nullable();
            $table->string('pendidikan', 100)->nullable();
            $table->text('keahlian_khusus')->nullable();
            $table->string('pengalaman', 100)->nullable();
            $table->string('kemampuan_bahasa_ing', 100)->nullable();
            $table->string('kemampuan_bahasa_ind', 100)->nullable();
            $table->string('kepribadian', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->integer('id_approval_al')->nullable();
            $table->integer('status_approval_al')->nullable();
            $table->date('tanggal_approval_al')->nullable();
            $table->text('desk_approval_al')->nullable();
            $table->integer('id_approval_hrd')->nullable();
            $table->integer('status_approval_hrd')->nullable();
            $table->date('tanggal_approval_hrd')->nullable();
            $table->text('desk_approval_hrd')->nullable();
            $table->integer("user_id");
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
        Schema::dropIfExists('hrd_recr_pengajuan_tk');
    }
}
