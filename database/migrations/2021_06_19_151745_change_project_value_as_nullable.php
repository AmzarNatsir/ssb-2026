<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProjectValueAsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('value',16,2)->nullable()->change();
            $table->integer('customer_id')->nullable()->change();
            $table->integer('is_tender')->nullable()->change();
            $table->string('target', 150)->nullable()->change();
            $table->string('location', 150)->nullable()->change();
            $table->integer('duration_in_month')->nullable()->change();
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
            $table->decimal('value',16,2);
            $table->integer('customer_id');
            $table->integer('is_tender');
            $table->string('target', 150);
            $table->string('location', 150);
            $table->integer('duration_in_month');
        });
    }
}
