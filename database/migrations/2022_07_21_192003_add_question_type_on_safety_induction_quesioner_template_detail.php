<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionTypeOnSafetyInductionQuesionerTemplateDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('safety_induction_quesioner_template_detail', function (Blueprint $table) {            
            $table->enum('question_type',['single','multiple'])->default('single')->comment('choose single or multiple')->after('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('safety_induction_quesioner_template_detail', function (Blueprint $table) {
            $table->dropColumn('question_type');
        });
    }
}
