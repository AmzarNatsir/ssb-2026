<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddFieldTujuanIdDepartemenInHrdPerdis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_perdis', function (Blueprint $table) {
            $table->string('tujuan', 200)->nullable();
            $table->integer('id_departemen')->nullable();
            $table->integer('diajukan_oleh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_perdis', function (Blueprint $table) {
            //
        });
    }
}
