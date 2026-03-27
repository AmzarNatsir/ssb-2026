<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEngineNoChassisNoEquipmentStatusAndDescColumnsEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('engine_no')->after('name')->nullable();
            $table->string('chassis_no')->after('name')->nullable();
            $table->integer('equipment_status_id')->after('name')->nullable();
            $table->string('desc')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['engine_no','chassis_no','equipment_status_id']);
        });
    }
}
