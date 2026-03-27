<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWorkshopPartOrderAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshop_part_order', function (Blueprint $table) {
            $table->smallInteger('status')->default(0); // 0 -> belum di proses di warehouse . 1 -> kalau sudah di proses di warehouse
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshop_part_order', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
