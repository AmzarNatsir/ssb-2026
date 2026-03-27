<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('serial_number')->nullable();
            $table->integer('production_year')->nullable();
            $table->string('model')->nullable();
            $table->smallInteger('status')->default(1);
            $table->bigInteger('pic');
            $table->text('description')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->text('location')->nullable();
            $table->string('picture')->nullable();
            $table->integer('hm')->default(0)->nullable();
            $table->integer('km')->default(0)->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('serial_number');
            $table->dropColumn('production_year');
            $table->dropColumn('model');
            $table->dropColumn('status');
            $table->dropColumn('pic');
            $table->dropColumn('description');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('location');
            $table->dropColumn('hm');
            $table->dropColumn('km');
            $table->dropColumn('picture');
            // $table->dropTimestamps();
        });
    }
}
