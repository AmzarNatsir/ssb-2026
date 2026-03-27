<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdPotonganKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_potongan_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer("id_potongan")->unsigned();
            $table->foreign("id_potongan")->references("id")->on("mst_hrd_potongan_gaji");
            $table->double('jumlah')->default(0);
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
        Schema::dropIfExists('hrd_potongan_karyawan');
    }
}
