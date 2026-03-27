<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstHrdProfilPerusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_hrd_profil_perusahaan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nm_perusahaan', 200)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('no_telpon', 50)->nullable();
            $table->string('no_fax', 50)->nullable();
            $table->string('nm_emaili', 100)->nullable();
            $table->string('nm_pimpinan', 150)->nullable();
            $table->string('logo_perusahaan', 50)->nullable();
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
        Schema::dropIfExists('mst_hrd_profil_perusahaan');
    }
}
