<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdSpNonAktif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_sp_non_aktif', function (Blueprint $table) {
            $table->id();
            $table->integer('id_sp');
            $table->text('alasan_non_aktif');
            $table->string('approval_key', 200);
            $table->integer('create_by');
            $table->integer('current_approval_id');
            $table->integer('is_draft'); //1: draff, 2: application
            $table->integer('sts_pengajuan'); //1: draff, 2: application
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
        Schema::dropIfExists('hrd_sp_non_aktif');
    }
}
