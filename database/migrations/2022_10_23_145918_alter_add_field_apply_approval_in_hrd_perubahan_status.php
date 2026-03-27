<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddFieldApplyApprovalInHrdPerubahanStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            $table->date('tgl_pengajuan')->nullable();
            $table->integer('id_departemen')->nullable();
            $table->integer('status_pengajuan')->nullable();
            $table->integer('diajukan_oleh')->nullable();
            $table->text('alasan_pengajuan')->nullable();
            $table->integer('id_persetujuan')->nullable();
            $table->integer('sts_persetujuan')->nullable();
            $table->date('tgl_persetujuan')->nullable();
            $table->text('ket_persetujuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            //
        });
    }
}
