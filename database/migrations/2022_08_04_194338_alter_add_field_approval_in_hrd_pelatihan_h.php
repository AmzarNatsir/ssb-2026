<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddFieldApprovalInHrdPelatihanH extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_pelatihan_h', function (Blueprint $table) {
            $table->text('alasan_pengajuan')->nullable();
            $table->double('total_investasi')->nullable();
            $table->integer('diajukan_by')->nullable();
            $table->integer('departemen_by')->nullable();
            $table->integer('status_pelatihan')->nullable(); //1.pengajuan, 2.pengajuan disetujui, 3.pengajuan ditolak, 4.pelatihan on progress, 5.pelatihan selesai, 6.pelatihan cancel
            $table->integer('id_approval')->nullable();
            $table->date('tgl_approval')->nullable();
            $table->text('catatam_approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_pelatihan_h', function (Blueprint $table) {
            //
        });
    }
}
