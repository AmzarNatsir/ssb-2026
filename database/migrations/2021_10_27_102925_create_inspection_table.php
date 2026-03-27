<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection', function (Blueprint $table) {
            $table->id();            
            $table->integer('inspection_checkpoint_id');
            $table->integer('location_id');
            $table->integer('equipment_id');
            $table->integer('report_set_id');
            $table->integer('officer_id');
            $table->integer('checkpoint');
            $table->string('assignment_no')->nullable();
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
        Schema::dropIfExists('inspection');
    }
}
