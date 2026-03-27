<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdInvestigasiHseBak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_bak', function (Blueprint $table) {
            $table->integer('id_investigasi_kecelakaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_bak', function (Blueprint $table) {
            $table->dropColumn('id_investigasi_kecelakaan');
        });
    }
}
