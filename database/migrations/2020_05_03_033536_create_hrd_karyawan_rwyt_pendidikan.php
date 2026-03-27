<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKaryawanRwytPendidikan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_karyawan_rwyt_pendidikan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer('id_jenjang')->nullable();
            $table->string('nm_sekolaj_pt', 200)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('mulai_tahun', 4)->nullable();
            $table->string('sampai_tahun', 4)->nullable();
            $table->string('file_ijazah', 50)->nullable();
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
        Schema::dropIfExists('hrd_karyawan_rwyt_pendidikan');
    }
}
