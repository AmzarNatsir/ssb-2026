<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_result', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id')->unsigned();
            $table->string('segment');
            $table->decimal('lng', 11, 8)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->string('note');
            $table->integer('surveyor_id')->unsigned();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('survey_result');
    }
}
