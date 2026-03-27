<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMandatoryColumnInspectionProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_properties', function (Blueprint $table) {
            $table->boolean('mandatory')->nullable()->after('dataset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspection_properties', function (Blueprint $table) {
            $table->dropColumn('mandatory');
        });
    }
}
