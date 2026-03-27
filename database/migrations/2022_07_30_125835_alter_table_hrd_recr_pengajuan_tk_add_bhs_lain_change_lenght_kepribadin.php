<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableHrdRecrPengajuanTkAddBhsLainChangeLenghtKepribadin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_recr_pengajuan_tk', function (Blueprint $table) {
            $table->text('kepribadian')->change();
            $table->string('kemampuan_bahasa_lain', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_recr_pengajuan_tk', function (Blueprint $table) {
            //
        });
    }
}
