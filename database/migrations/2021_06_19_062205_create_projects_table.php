<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->text('source');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status');
            $table->decimal('value',16, 2);
            $table->integer('customer_id');
            $table->tinyInteger('category_id');
            $table->tinyInteger('is_tender');
            $table->string('target', 150);
            $table->string('location', 150);
            $table->integer('duration_in_month');
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
        Schema::dropIfExists('projects');
    }
}
