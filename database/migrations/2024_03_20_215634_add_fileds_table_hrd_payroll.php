<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledsTableHrdPayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hrd_payroll', function (Blueprint $table) {
            $table->double('pot_sedekah')->nullable();
            $table->double('pot_pkk')->nullable();
            $table->double('pot_air')->nullable();
            $table->double('pot_rumah')->nullable();
            $table->double('pot_toko_alif')->nullable();
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
