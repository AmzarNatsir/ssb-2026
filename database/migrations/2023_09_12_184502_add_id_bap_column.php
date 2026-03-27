<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdBapColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hse_realisasi_limbah', function (Blueprint $table) {
            $table->integer('id_bap_limbah')->nullable()->after('id_prsh_jasa_angkutan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hse_realisasi_limbah', function (Blueprint $table) {
            $table->dropColumn('id_bap_limbah');
        });
    }
}
