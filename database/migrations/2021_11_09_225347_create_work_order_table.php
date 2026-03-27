<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->smallInteger('status');
            $table->bigInteger('work_request_id');
            $table->bigInteger('equipment_id');
            $table->bigInteger('driver_id');
            $table->bigInteger('project_id');
            $table->bigInteger('supervisor_id');
            $table->integer('hm')->nullable();
            $table->integer('km')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_finish')->nullable();
            $table->string('man_powers')->nullable();
            $table->string('repairing_plan')->nullable();
            $table->text('damage_source_analysis')->nullable();
            $table->smallInteger('can_be_reoperated')->nullable();
            $table->smallInteger('need_further_treatment')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('work_order');
    }
}
