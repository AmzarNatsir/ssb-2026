<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_mutasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_karyawan")->unsigned();
            $table->foreign("id_karyawan")->references("id")->on("hrd_karyawan");
            $table->integer('no_auto')->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->date('tgl_surat')->nullable();
            $table->integer('kategori')->nullable();
            $table->integer('id_divisi_lm')->nullable();
            $table->integer('id_dept_lm')->nullable();
            $table->integer('id_subdept_lm')->nullable();
            $table->integer('id_jabt_lm')->nullable();
            $table->integer('id_divisi_br')->nullable();
            $table->integer('id_dept_br')->nullable();
            $table->integer('id_subdept_br')->nullable();
            $table->integer('id_jabt_br')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('id_ttd')->nullable();
            $table->integer('id_user')->nullable();
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
        Schema::dropIfExists('hrd_mutasi');
    }
}
