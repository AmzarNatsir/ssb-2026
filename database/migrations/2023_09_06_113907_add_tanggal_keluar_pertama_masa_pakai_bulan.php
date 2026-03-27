<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalKeluarPertamaMasaPakaiBulan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_apd', function (Blueprint $table) {
            $table->date('tanggal_keluar_pertama')->nullable()->after('tanggal_pembelian');
            $table->renameColumn('masa_pakai_tahun', 'masa_pakai_bulan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_apd', function (Blueprint $table) {
            $table->dropColumn('tanggal_keluar_pertama');
            $table->renameColumn('masa_pakai_bulan', 'masa_pakai_tahun');
        });
    }
}
