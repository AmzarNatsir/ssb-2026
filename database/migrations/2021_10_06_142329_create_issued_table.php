<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->bigInteger('reference_id')->nullable();
            $table->text('remarks')->nullable();
            $table->datetime('received_at');
            $table->smallInteger('status');
            $table->bigInteger('received_by')->nullable();
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
        Schema::dropIfExists('issued');
    }
}
