<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHargaSatuanMstHseLimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_hse_limbah', function (Blueprint $table) {
            $table->double('harga_satuan', 18, 2)->nullable()->after('unit_id')->default(0);
            $table->string('kode', 15)->nullable();
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
            $table->dropColumn('harga_satuan');
            $table->dropColumn('kode');
        });
    }
}
