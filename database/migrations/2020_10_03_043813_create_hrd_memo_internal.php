<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdMemoInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_memo_internal', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_post');
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->string('file_memo', 50);
            $table->integer('status');
            $table->integer('id_user');
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
        Schema::dropIfExists('hrd_memo_internal');
    }
}
