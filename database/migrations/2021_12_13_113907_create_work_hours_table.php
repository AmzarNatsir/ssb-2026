<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_hours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->bigInteger('operator_id');
            $table->bigInteger('equipment_id');
            $table->bigInteger('user_id');
            $table->smallInteger('km_start')->nullable();
            $table->smallInteger('km_end')->nullable();
            $table->smallInteger('hm_start')->nullable();
            $table->smallInteger('hm_end')->nullable();
            $table->smallInteger('shift')->nullable();
            $table->time('operating_hour_start');
            $table->time('operating_hour_end');
            $table->time('break_hour_start')->nullable();
            $table->time('break_hour_end')->nullable();
            $table->time('break_hour_total')->nullable();
            $table->text('keterangan')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_hours');
    }
}
