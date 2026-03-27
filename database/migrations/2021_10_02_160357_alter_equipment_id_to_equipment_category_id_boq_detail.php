<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEquipmentIdToEquipmentCategoryIdBoqDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boq_detail', function (Blueprint $table) {
            $table->renameColumn('equipment_id', 'equipment_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boq_detail', function (Blueprint $table) {
            $table->renameColumn('equipment_category_id', 'equipment_id');
        });
    }
}
