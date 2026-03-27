<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchasingComparisonTableAddReferenceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasing_comparison', function (Blueprint $table) {
            $table->bigInteger('reference_id')->after('purchasing_request_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchasing_comparison', function (Blueprint $table) {
            $table->dropColumn('reference_id');
        });
    }
}
