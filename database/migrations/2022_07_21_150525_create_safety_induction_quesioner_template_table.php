<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafetyInductionQuesionerTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safety_induction_quesioner_template', function (Blueprint $table) {
            $table->id();
            $table->text('notes');
            $table->string('scoring', 150);// M CM TM
            $table->integer('is_active')->unsigned();
            $table->date('active_date');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('safety_induction_quesioner_template');
    }
}
