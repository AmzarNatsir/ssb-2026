<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldFileHasilEvaluasiToHrdPerubahanStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            $table->string('file_hasil_evaluasi', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            //
        });
    }
}
