<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseTestPemahamanSafety extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_test_pemahaman_safety', function (Blueprint $table) {
            $table->id();
            $table->string('nik_karyawan', 50)->nullable();
            $table->string('no_dokumen', 150)->nullable();
            $table->string('file_quesioner', 150)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('hse_test_pemahaman_safety');
    }
}
