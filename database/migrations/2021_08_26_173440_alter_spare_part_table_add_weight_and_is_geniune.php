<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSparePartTableAddWeightAndIsGeniune extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_part', function (Blueprint $table) {
            $table->float('weight')->after('stock')->nullable();
            $table->boolean('is_geniune')->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sparepart', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->dropColumn('is_geniune');
        });
    }
}
