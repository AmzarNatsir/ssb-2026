<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsOnSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('supplier', function (Blueprint $table) {
        $table->string('bank_name');
        $table->string('bank_number');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('supplier', function (Blueprint $table) {
        $table->dropColumn('bank_name');
        $table->dropColumn('bank_number');
      });
    }
}
