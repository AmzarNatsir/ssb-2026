<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusAndTypeProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('status', 'status_id');
            $table->renameColumn('type', 'tipe_id');
            $table->renameColumn('target', 'target_tender_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('status_id', 'status');
            $table->renameColumn('tipe_id', 'type');
            $table->renameColumn('target_tender_id', 'target');
        });
    }
}
