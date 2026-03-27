<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoTglSuratPengantarToHrdRecrPelamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            $table->string('no_surat_pengantar', 100)->nullable();
            $table->date('tgl_surat_pengantar')->nullable();
            $table->integer('id_jenjang')->nullable();
            $table->integer('surat_by')->nullable();
            $table->integer('hrd_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            //
        });
    }
}
