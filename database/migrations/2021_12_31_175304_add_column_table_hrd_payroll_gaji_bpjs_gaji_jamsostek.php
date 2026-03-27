<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableHrdPayrollGajiBpjsGajiJamsostek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_payroll', function (Blueprint $table) {
            $table->double('gaji_bpjs')->nullable();
            $table->double('gaji_jamsostek')->nullable();
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
            //
        });
    }
}
