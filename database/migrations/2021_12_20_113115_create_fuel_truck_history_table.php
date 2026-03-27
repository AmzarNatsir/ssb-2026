<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelTruckHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_truck_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fuel_truck_id');
            $table->string('module');
            $table->morphs('reference');
            $table->string('method')->nullable();
            $table->integer('stock');
            $table->integer('updated_stock');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('fuel_truck_history');
    }
}
