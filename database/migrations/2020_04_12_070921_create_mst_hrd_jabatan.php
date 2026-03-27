<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdJabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_jabatan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_level")->unsigned();
            $table->foreign("id_level")->references("id")->on("mst_hrd_level_jabatan");
            $table->integer('id_dept')->nullable();
            $table->integer('id_subdept')->nullable();
            $table->integer('id_gakom')->nullable();
            $table->integer('id_gakor')->nullable();
            $table->string('nm_jabatan', '150')->nullable();
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
        Schema::dropIfExists('mst_hrd_jabatan');
    }
}
