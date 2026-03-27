<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_changes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('spare_part_id');
            $table->string('module');
            $table->text('reference');
            $table->string('method');
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
        Schema::dropIfExists('stock_changes');
    }
}
