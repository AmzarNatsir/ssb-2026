<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoqDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boq_detail', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('boq_id')->constrained('boq')->onUpdate('cascade')->onDelete('cascade');
            $table->string('desc');
            $table->integer('qty');
            $table->integer('target');
            $table->decimal('price',16, 2);            
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
        Schema::dropIfExists('boq_detail');
    }
}
