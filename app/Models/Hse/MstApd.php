<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstApd extends Model
{
    protected $table="mst_apd";
    protected $fillable = ['nama_apd','tanggal_pembelian','tanggal_keluar_pertama','masa_pakai_bulan','masa_ganti_bulan','stock','status'];
}
