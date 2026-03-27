<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelTankConsumptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_tank_consumption', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('number');
            $table->bigInteger('fuel_tank_id');
            $table->morphs('reference');
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
        Schema::dropIfExists('fuel_tank_consumption');
    }
}
