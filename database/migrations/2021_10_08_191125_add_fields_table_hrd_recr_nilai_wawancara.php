<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTableHrdRecrNilaiWawancara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_recr_nilai_wawancara', function (Blueprint $table) {
            $table->text('keterangan_1')->nullable();
            $table->text('keterangan_2')->nullable();
            $table->text('keterangan_3')->nullable();
            $table->text('keterangan_4')->nullable();
            $table->text('keterangan_5')->nullable();
            $table->text('keterangan_6')->nullable();
            $table->text('keterangan_7')->nullable();
            $table->text('keterangan_8')->nullable();
            $table->text('keterangan_9')->nullable();
            $table->text('keterangan_10')->nullable();
            $table->text('keterangan_11')->nullable();
            $table->text('keterangan_12')->nullable();
            $table->text('keterangan_13')->nullable();
            $table->text('keterangan_14')->nullable();
            $table->text('keterangan_15')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_recr_nilai_wawancara', function (Blueprint $table) {
            //
        });
    }
}
