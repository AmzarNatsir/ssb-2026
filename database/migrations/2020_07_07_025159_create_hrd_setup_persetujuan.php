<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdSetupPersetujuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_setup_persetujuan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modul', 200);
            $table->string('lvl_pengajuan', 50)->nullable();
            $table->integer('lvl_persetujuan')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('hrd_setup_persetujuan');
    }
}
