<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingComparisonDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_comparison_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchasing_comparison_id');
            $table->bigInteger('supplier_id');
            $table->bigInteger('part_id');
            $table->integer('qty');
            $table->double('price');
            $table->integer('eta')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasing_comparison_detail');
    }
}
