<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseBak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_bak', function (Blueprint $table) {
            $table->id();
            $table->string('no_form')->nullable();
            $table->string('nama_site')->nullable();
            $table->date('tgl_kejadian')->nullable();
            $table->time('jam_kejadian', $precision = 0)->nullable();
            $table->integer('id_karyawan')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('kronologis')->nullable();
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
        Schema::dropIfExists('hse_bak');
    }
}
