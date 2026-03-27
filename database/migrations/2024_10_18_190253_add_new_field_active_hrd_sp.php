<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldActiveHrdSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_sp', function (Blueprint $table) {
            $table->integer('sp_lama_active')->nullable();
            $table->date("sp_mulai_active")->nullable();
            $table->date('sp_akhir_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_sp', function (Blueprint $table) {
            //
        });
    }
}
