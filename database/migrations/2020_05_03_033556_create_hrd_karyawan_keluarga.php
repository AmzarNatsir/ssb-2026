<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKaryawanKeluarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_karyawan_keluarga', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer('id_hubungan')->nullable();
            $table->string('nm_keluarga', 200)->nullable();
            $table->string('tmp_lahir', 200)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->integer('jenkel')->nullable();
            $table->integer('id_jenjang')->nullable();
            $table->string('pekerjaan', 200)->nullable();
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
        Schema::dropIfExists('hrd_karyawan_keluarga');
    }
}
