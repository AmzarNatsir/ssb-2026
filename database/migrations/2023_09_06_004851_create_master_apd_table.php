<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterApdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_apd', function (Blueprint $table) {
            $table->id();
            $table->string('nama_apd');
            $table->date('tanggal_pembelian')->nullable();
            $table->tinyInteger('masa_pakai_tahun')->unsigned();
            $table->tinyInteger('masa_ganti_bulan')->unsigned();
            $table->integer('stock')->unsigned();
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
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
        Schema::dropIfExists('mst_apd');
    }
}
