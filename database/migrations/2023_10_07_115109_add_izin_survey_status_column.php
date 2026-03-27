<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIzinSurveyStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('izin_survey_date')->after('updated_by')->nullable();
            $table->tinyInteger('izin_survey_status')->default(0)->after('updated_by')->comment('0: Belum, 1: Sudah')->nullable();
            $table->tinyInteger('izin_survey_approved_by')->after('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('izin_survey_date');
            $table->dropColumn('izin_survey_status');
            $table->dropColumn('izin_survey_approved_by');
        });
    }
}
