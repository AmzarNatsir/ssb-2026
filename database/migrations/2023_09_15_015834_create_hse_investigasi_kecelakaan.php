<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseInvestigasiKecelakaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_investigasi_kecelakaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen')->nullable();
            $table->string('no_revisi')->nullable();
            $table->string('no_form')->nullable();
            // $table->string('nama_site')->nullable();
            // $table->date('tgl_kejadian')->nullable();
            // $table->time('jam_kejadian', $precision = 0)->nullable();
            // $table->integer('id_karyawan')->nullable();
            $table->integer('user_id')->nullable();
            // $table->text('kronologis')->nullable();
            $table->text('fakta_investigasi')->nullable();
            $table->json('jenis_kejadian')->nullable();
            $table->json('rincian_bagian_tubuh')->nullable();
            $table->json('rincian_accident_lingkungan')->nullable();
            $table->json('rincian_kerusakan_alat')->nullable();
            $table->json('ketua_tim')->nullable();
            $table->json('anggota_tim')->nullable();
            $table->json('saksi')->nullable();
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
        Schema::dropIfExists('hse_investigasi_kecelakaan');
    }
}
