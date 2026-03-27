<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_order', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('purchasing_comparison_id');
            $table->bigInteger('reference_id')->nullable();
            $table->bigInteger('supplier_id');
            $table->double('subtotal')->default('0');
            $table->double('total_discount')->default('0');
            $table->double('ppn')->default('0');
            $table->double('additional_expense')->default('0');
            $table->double('grand_total')->default('0');
            $table->dateTime('send_date');
            $table->bigInteger('approved_by');
            $table->bigInteger('created_by');
            $table->text('remarks')->nullable();
            $table->smallInteger('status');
            $table->smallInteger('purchasing_order_status');
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
        Schema::dropIfExists('purchasing_order');
    }
}
