<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_order_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchasing_order_id');
            $table->bigInteger('part_id');
            $table->integer('qty');
            $table->double('price');
            $table->double('discount')->default('0');
            $table->text('remarks')->nullable();
            $table->smallInteger('status')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasing_order_detail');
    }
}
