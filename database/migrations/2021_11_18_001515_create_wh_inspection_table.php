<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhInspectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_inspection', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('number');
            $table->bigInteger('equipment_id');
            $table->bigInteger('location_id');
            $table->bigInteger('project_id');
            $table->bigInteger('driver_id');
            $table->smallInteger('shift')->nullable();
            $table->smallInteger('km_start')->nullable();
            $table->smallInteger('km_end')->nullable();
            $table->smallInteger('operating_hour');
            $table->smallInteger('standby_hour')->nullable();
            $table->smallInteger('breakdown_hour')->nullable();
            $table->text('standby_description')->nullable();
            $table->text('breakdown_description')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_inspection');
    }
}
