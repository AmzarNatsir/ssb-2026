<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdRecrPelamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_recr_pelamar', function (Blueprint $table) {
            $table->increments("id");
            $table->string("no_identitas", 100);
            $table->string("nama_lengkap", 200);
            $table->string("tempat_lahir", 200);
            $table->date("tanggal_lahir");
            $table->integer("jenkel");
            $table->integer("id_agama");
            $table->string("alamat", 200);
            $table->string("no_hp", 50);
            $table->string("no_wa", 50);
            $table->string("email", 200);
            $table->string("file_photo", 50);
            $table->integer("status")->nullable();
            $table->integer("id_departemen")->nullable();
            $table->integer("id_sub_departemen")->nullable();
            $table->integer("id_jabatan")->nullable();
            $table->integer("id_lowongan")->nullable();
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
        Schema::dropIfExists('hrd_recr_pelamar');
    }
}
