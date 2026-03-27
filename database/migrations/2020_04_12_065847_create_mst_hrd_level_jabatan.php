<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdLevelJabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_level_jabatan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nm_level', 100)->nullable();
            $table->integer('sts_dept')->nullable();
            $table->integer('sts_subdept')->nullable();
            $table->integer('sts_gakom')->nullable();
            $table->integer('sts_gakor')->nullable();
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
        Schema::dropIfExists('mst_hrd_level_jabatan');
    }
}
