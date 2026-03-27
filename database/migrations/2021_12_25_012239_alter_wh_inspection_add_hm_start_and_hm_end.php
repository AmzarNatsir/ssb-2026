<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWhInspectionAddHmStartAndHmEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wh_inspection', function (Blueprint $table) {
            $table->smallInteger('hm_start')->nullable();
            $table->smallInteger('hm_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wh_inspection', function (Blueprint $table) {
            $table->dropColumn('hm_start');
            $table->dropColumn('hm_end');
        });
    }
}
