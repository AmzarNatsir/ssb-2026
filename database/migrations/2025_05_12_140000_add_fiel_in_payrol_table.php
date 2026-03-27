<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielInPayrolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_payroll', function (Blueprint $table) {
            $table->double('bonus')->nullable();
            $table->double('gaji_bruto')->nullable();
            $table->double('pot_tunj_perusahaan')->nullable();
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
