<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldHasilTestTableHrdRecrPelamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            $table->integer('psikotes_nilai')->nullable();
            $table->string('psikotes_ket', 200)->nullable();
            $table->string('psikotes_kesimpulan', 50)->nullable();
            $table->integer('wawancara_nilai')->nullable();
            $table->string('wawancara_ket', 200)->nullable();
            $table->string('wawancara_kesimpulan', 50)->nullable();
            $table->integer('total_skor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_recr_pelamar', function (Blueprint $table) {
            //
        });
    }
}
