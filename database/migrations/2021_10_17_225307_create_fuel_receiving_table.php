<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelReceivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_receiving', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('supplier_id');
            $table->bigInteger('fuel_tank_id');
            $table->string('vehicle_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('invoice_number')->nullable();
            $table->integer('invoice_amount')->nullable();
            $table->integer('real_amount')->nullable();
            $table->integer('difference')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by');
            $table->softDeletes();
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
        Schema::dropIfExists('fuel_receiving');
    }
}
