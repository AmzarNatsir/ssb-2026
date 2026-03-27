<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedInteger('hm')->nullable();
            $table->unsignedInteger('km')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('mechanic_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('check_result')->nullable();
            $table->json('checklists')->nullable();
            $table->date('inspection_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('work_order_id')
                  ->references('id')
                  ->on('work_order');

            $table->foreign('location_id')
                  ->references('id')
                  ->on('location');

            $table->foreign('mechanic_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_inspections');
    }
}
