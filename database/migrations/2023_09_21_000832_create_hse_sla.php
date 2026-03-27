<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseSla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_sla', function (Blueprint $table) {
            $table->id();
            $table->string('form_number')->nullable();
            $table->string('location')->nullable();
            $table->date('audit_date')->nullable();
            $table->time('audit_start_time')->nullable();
            $table->time('audit_end_time')->nullable();
            $table->json('audit_teams')->nullable();
            $table->json('audit_actionables')->nullable();
            $table->json('audit_findings')->nullable();
            $table->json('safety_behaviors')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('hse_sla');
    }
}
