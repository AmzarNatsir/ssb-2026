<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part', function (Blueprint $table) {
            $table->id();
            $table->string('part_number');
            $table->string('interchange')->nullable();
            $table->string('part_name');
            $table->bigInteger('brand_id');
            $table->bigInteger('uop_id');
            $table->bigInteger('category_id');
            $table->double('price');
            $table->string('rack')->nullable();
            $table->string('location')->nullable();
            $table->string('used_for')->nullable();
            $table->integer('min_stock');
            $table->integer('max_stock');
            $table->integer('stock');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('spare_part');
    }
}
