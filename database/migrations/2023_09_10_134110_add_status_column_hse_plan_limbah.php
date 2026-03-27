<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnHsePlanLimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_plan_limbah', function (Blueprint $table) {
            $table->string('status', 25)->default('plan')->after('keterangan')->comment('plan, realisasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_plan_limbah', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
