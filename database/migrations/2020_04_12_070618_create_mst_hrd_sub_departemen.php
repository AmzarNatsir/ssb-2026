<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdSubDepartemen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_sub_departemen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("id_dept")->unsigned();
            $table->foreign("id_dept")->references("id")->on("mst_hrd_departemen");
            $table->string('nm_subdept', 100)->nullable();
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
        Schema::dropIfExists('mst_hrd_sub_departemen');
    }
}
