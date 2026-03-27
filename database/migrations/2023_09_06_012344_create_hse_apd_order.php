<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseApdOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_apd_order', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_order');
            $table->integer('id_apd')->unsigned();
            $table->integer('id_pengorder')->unsigned();
            $table->string('no_order')->nullable();
            $table->integer('qty')->nullable();
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
        Schema::dropIfExists('hse_apd_order');
    }
}
