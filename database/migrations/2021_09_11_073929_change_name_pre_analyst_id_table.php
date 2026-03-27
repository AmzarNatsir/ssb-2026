<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNamePreAnalystIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_analyst_file', function (Blueprint $table) {            
            $table->renameColumn('pre_analyst_id', 'pre_analyst_approval_id');         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_analyst_file', function (Blueprint $table) {
            $table->renameColumn('pre_analyst_approval_id', 'pre_analyst_id');            
        });
    }
}
