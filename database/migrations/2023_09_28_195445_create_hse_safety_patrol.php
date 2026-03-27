<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseSafetyPatrol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_safety_patrol', function (Blueprint $table) {
            $table->id();
            $table->date("tgl_patroli")->nullable();
            $table->json("hse_officer")->nullable();
            $table->json("locations")->nullable();
            $table->integer("status")->default(1)->nullable()->comment('1=scheduled 2=patroled');
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
        Schema::dropIfExists('hse_safety_patrol');
    }
}
