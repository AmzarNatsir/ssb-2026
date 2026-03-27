<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdJenisCutiIzin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_jenis_cuti_izin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_ci')->nullable();
            $table->string('nm_jenis_ci', '100')->nullable();
            $table->integer('lama_cuti')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('mst_hrd_jenis_cuti_izin');
    }
}
