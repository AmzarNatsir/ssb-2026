<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdKaryawanDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_karyawan_dokumen', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer("id_dokumen")->nullable();
            $table->string("file_dokumen", 50)->nullable();
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
        Schema::dropIfExists('hrd_karyawan_dokumen');
    }
}
