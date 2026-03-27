<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_approval', function (Blueprint $table) {
            $table->increments('id');
            $table->string("approval_key");
            $table->integer("approval_group");
            $table->integer("approval_level");
            $table->integer("approval_by_employee");
            $table->date("approval_date")->nullable();
            $table->integer("approval_status")->nullable();
            $table->text("approval_remark")->nullable();
            $table->integer("approval_active");
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
        Schema::dropIfExists('hrd_approval');
    }
}
