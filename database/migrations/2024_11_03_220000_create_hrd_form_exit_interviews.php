<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdFormExitInterviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_form_exit_interviews', function (Blueprint $table) {
            $table->id();
            $table->integer('id_head');
            $table->text('jawaban_1')->nullable();
            $table->string('jawaban_1_1', 100)->nullable();
            $table->string('jawaban_1_2', 100)->nullable();
            $table->double('jawaban_1_3')->nullable();
            $table->text('jawaban_2')->nullable();
            $table->text('jawaban_3')->nullable();
            $table->text('jawaban_4')->nullable();
            $table->text('jawaban_5')->nullable();
            $table->text('jawaban_6')->nullable();
            $table->string('jawaban_6_1', 100)->nullable();
            $table->string('jawaban_6_2', 100)->nullable();
            $table->text('jawaban_7')->nullable();
            $table->string('jawaban_8', 20)->nullable();
            $table->text('jawaban_8_1')->nullable();
            $table->text('jawaban_9')->nullable();
            $table->integer('jawaban_9_1')->nullable();
            $table->integer('jawaban_9_2')->nullable();
            $table->integer('jawaban_9_3')->nullable();
            $table->integer('jawaban_9_4')->nullable();
            $table->integer('jawaban_9_5')->nullable();
            $table->integer('jawaban_9_6')->nullable();
            $table->integer('jawaban_9_7')->nullable();
            $table->integer('jawaban_9_8')->nullable();
            $table->integer('jawaban_9_9')->nullable();
            $table->text('jawaban_10')->nullable();
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
        Schema::dropIfExists('hrd_form_exit_interviews');
    }
}
