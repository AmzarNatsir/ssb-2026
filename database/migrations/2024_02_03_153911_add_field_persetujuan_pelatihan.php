<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPersetujuanPelatihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_pelatihan_h', function (Blueprint $table) {
            $table->dropForeign('hrd_pelatihan_h_id_pelatihan_foreign');
            $table->dropIndex('hrd_pelatihan_h_id_pelatihan_foreign');
            $table->dropForeign('hrd_pelatihan_h_id_pelaksana_foreign');
            $table->dropIndex('hrd_pelatihan_h_id_pelaksana_foreign');
            $table->string('kategori', 50)->nullable();
            $table->string('nama_pelatihan', 200)->nullable();
            $table->string('nama_vendor', 200)->nullable();
            $table->string('kontak_vendor', 50)->nullable();
            $table->string('durasi', 50)->nullable();
            $table->text('kompetensi')->nullable();
            $table->double('investasi_per_orang')->nullable();
            $table->string('approval_key')->nullable();
            $table->integer('status_pengajuan')->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable(); //1=default -> Masih bisa diedit; 2. Tidak bisa diedit;
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
