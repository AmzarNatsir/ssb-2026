<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnTwoFieldsHrdMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_mutasi', function (Blueprint $table) {
            $table->date('tgl_efektif_lm')->nullable();
            $table->date('tgl_efektif_br')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_mutasi', function (Blueprint $table) {
            //
        });
    }
}
