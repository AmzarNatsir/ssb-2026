<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelTruckConsumptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_truck_consumption', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('number');
            $table->bigInteger('fuel_truck_id');
            $table->bigInteger('equipment_id')->nullable();
            $table->integer('amount');
            $table->integer('current_stock');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('fuel_truck_consumption');
    }
}
