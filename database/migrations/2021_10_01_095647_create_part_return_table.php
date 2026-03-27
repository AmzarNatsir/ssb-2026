<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_return', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('supplier_id');
            $table->bigInteger('purchasing_order_id');
            $table->bigInteger('reference_id')->nullable();
            $table->double('subtotal')->default('0');
            $table->double('ppn')->default('0');
            $table->double('grand_total')->default('0');
            $table->smallInteger('status');
            $table->smallInteger('return_status');
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('part_return');
    }
}
