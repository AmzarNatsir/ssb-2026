<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchasingRequestAddTotalQtyAndTotalPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasing_request', function (Blueprint $table) {
            $table->integer('total_qty')->after('remarks');
            $table->double('total_price')->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchasing_request', function (Blueprint $table) {
            $table->dropColumn('total_qty');
            $table->dropColumn('total_price');
        });
    }
}
