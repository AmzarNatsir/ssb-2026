<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionChecklistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_checklist_group_id');
            $table->string('name');
            $table->smallInteger('order', false, true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('inspection_checklist_group_id')
                  ->references('id')
                  ->on('inspection_checklist_groups')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_checklist_items');
    }
}
