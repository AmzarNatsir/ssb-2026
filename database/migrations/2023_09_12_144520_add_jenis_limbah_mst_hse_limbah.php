<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisLimbahMstHseLimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_hse_limbah', function (Blueprint $table) {
            $table->enum('jenis_limbah', ['B3', 'Non B3'])->default('B3')->after('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_hse_limbah', function (Blueprint $table) {
            $table->dropColumn('jenis_limbah');
        });
    }
}
