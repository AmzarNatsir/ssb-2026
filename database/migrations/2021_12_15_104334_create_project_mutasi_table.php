<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_mutasi', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->bigInteger('employee_id');
            $table->integer('new_dept');
            $table->integer('new_jabt');
            $table->date('eff_date');
            $table->text('ketera')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_mutasi');
    }
}
