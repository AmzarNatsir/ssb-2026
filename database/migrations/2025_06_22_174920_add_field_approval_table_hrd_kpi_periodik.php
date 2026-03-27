<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldApprovalTableHrdKpiPeriodik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_kpi_periodik', function (Blueprint $table) {
            $table->string('approval_key', 100)->nullable();
            $table->integer('status_pengajuan')->nullable();
            $table->integer('current_approval_id')->nullable();
            $table->integer('is_draft')->nullable();
            $table->integer('diajukan_oleh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_kpi_periodik', function (Blueprint $table) {
            //
        });
    }
}
