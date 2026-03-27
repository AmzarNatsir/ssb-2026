<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSholatTableHrdAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_absensi', function (Blueprint $table) {
            $table->string('dhuhur', 2)->nullable(); // y atau t
            $table->string('ashar', 2)->nullable(); // y atau t
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_absensi', function (Blueprint $table) {
            //
        });
    }
}
