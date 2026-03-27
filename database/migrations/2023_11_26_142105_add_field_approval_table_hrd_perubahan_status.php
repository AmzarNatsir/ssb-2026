<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldApprovalTableHrdPerubahanStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            $table->string('approval_key')->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable(); //1=default -> Masih bisa diedit; 2. Tidak bisa diedit;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_perubahan_status', function (Blueprint $table) {
            //
        });
    }
}
