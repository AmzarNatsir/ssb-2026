<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsaDanTestPemahamanRelasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_safety_induction', function (Blueprint $table) {
            $table->integer('jsa_id')->unsigned()->nullable();
            $table->integer('test_pemahaman_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_safety_induction', function (Blueprint $table) {
            $table->dropColumn('jsa_id');
            $table->dropColumn('test_pemahaman_id');
        });
    }
}
