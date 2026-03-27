<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartReturnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_return_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('part_return_id');
            $table->bigInteger('purchasing_order_detail_id');
            $table->bigInteger('part_id');
            $table->integer('qty');
            $table->double('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_return_detail');
    }
}
