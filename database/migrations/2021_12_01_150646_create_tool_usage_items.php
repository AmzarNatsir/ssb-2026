<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolUsageItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_usage_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tool_usage_id');
            $table->bigInteger('tools_id');
            $table->smallInteger('qty');
            $table->smallInteger('status')->default(0);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool_usage_items');
    }
}
