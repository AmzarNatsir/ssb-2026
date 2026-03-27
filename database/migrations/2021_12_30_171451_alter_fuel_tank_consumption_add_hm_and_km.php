<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFuelTankConsumptionAddHmAndKm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_tank_consumption', function (Blueprint $table) {
            $table->integer('hm')->nullable();
            $table->integer('km')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_tank_consumption', function (Blueprint $table) {
            $table->dropColumn('hm');
            $table->dropColumn('km');
        });
    }
}
