<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchasingComparisonTableAddPurchasingRequestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasing_comparison', function (Blueprint $table) {
            $table->bigInteger('purchasing_request_id')->after('number');
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
            $table->dropColumn('purchasing_request_id');
        });
    }
}
