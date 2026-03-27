<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class OpsiKategoriProject extends Model
{
    public $timestamps = false;
    protected $table = "opsi_kategori_project";
    protected $fillable = ['keterangan'];
}
