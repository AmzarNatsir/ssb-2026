<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafetyInductionSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safety_induction_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('safety_inductions_id');
            $table->string('name');
            $table->string('docnumber', 150);
            $table->integer('file_types_id')->nullable();
            $table->string('filename')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('safety_induction_steps');
    }
}
