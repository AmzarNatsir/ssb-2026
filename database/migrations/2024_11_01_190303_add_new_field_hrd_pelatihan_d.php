<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldHrdPelatihanD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_pelatihan_d', function (Blueprint $table) {
            $table->text('tujuan_pelatihan_pasca')->nullable();
            $table->text('uraian_materi_pasca')->nullable();
            $table->text('tindak_lanjut_pasca')->nullable();
            $table->text('dampak_pasca')->nullable();
            $table->text('penutup_pasca')->nullable();
            $table->string('evidence_pasca', 100)->nullable();
            $table->string('pasca', 1)->nullable(); //null/1= karyawan telah melaporkan kegiatan pelatihan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_pelatihan_d', function (Blueprint $table) {
            //
        });
    }
}
