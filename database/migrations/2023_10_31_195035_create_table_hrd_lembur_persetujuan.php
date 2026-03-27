<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHrdLemburPersetujuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_lembur_persetujuan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_lembur")->unsigned();
            $table->foreign("id_lembur")->references("id")->on("hrd_lembur");
            $table->integer('level');
            $table->integer('id_pejabat');
            $table->integer('status_persetujuan')->nullable();
            $table->date('tgl_persetujuan')->nullable();
            $table->text('ket_persetujuan')->nullable();
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
        Schema::dropIfExists('hrd_lembur_persetujuan');
    }
}
