<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdSuratTeguran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_surat_teguran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->date('tanggal_kejadian');
            $table->time('waktu_kejadian');
            $table->string('tempat_kejadian', 150);
            $table->integer("id_jenis_pelanggaran")->unsigned();
            $table->foreign("id_jenis_pelanggaran")->references("id")->on("mst_hrd_jenis_pelanggaran");
            $table->text('akibat')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->text('komentar_pelanggar')->nullable();
            $table->date('tanggal_pengajuan');
            $table->string('approval_key')->nullable();
            $table->integer('status_pengajuan')->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable(); //1=default -> Masih bisa diedit; 2. Tidak bisa diedit;
            $table->integer('create_by');
            $table->string('no_st')->nullable();
            $table->date('tgl_st')->nullable();
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
        Schema::dropIfExists('hrd_surat_teguran');
    }
}
