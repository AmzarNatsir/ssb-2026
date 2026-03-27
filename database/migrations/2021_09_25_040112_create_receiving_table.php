<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiving', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('purchasing_order_id');
            $table->bigInteger('reference_id')->nullable();
            $table->bigInteger('supplier_id');
            $table->string('invoice_number');
            $table->text('remarks')->nullable();
            $table->smallInteger('status');
            $table->bigInteger('created_by');
            $table->bigInteger('received_by');
            $table->bigInteger('approved_by');
            $table->dateTime('received_at');
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
        Schema::dropIfExists('receiving');
    }
}
