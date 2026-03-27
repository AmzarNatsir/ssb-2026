<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_changes', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->bigInteger('fuel_tank_id');
            $table->bigInteger('reference_id');
            $table->string('reference');
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
        Schema::dropIfExists('fuel_changes');
    }
}
