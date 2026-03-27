<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHrdPayrollAddFlagApprstsApprbyApprdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_payroll', function (Blueprint $table) {
            $table->integer('flag')->nullable(); //NULL is default -> submission, 1 -> approved
            $table->dateTime('appr_date')->nullable();
            $table->integer('appr_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hrd_payroll', function (Blueprint $table) {
            $table->integer('flag')->nullable();
            $table->dateTime('appr_date')->nullable();
            $table->integer('appr_by')->nullable();
        });
    }
}
