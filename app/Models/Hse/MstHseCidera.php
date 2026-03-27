<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstHseCidera extends Model
{
    protected $table = "mst_hse_cidera";
    protected $fillable = ["name","id_kategori_cidera"];

    public function kategori_cidera(){
        return $this->belongsTo('App\Models\Hse\MstHseKategoriCidera', 'id_kategori_cidera');
    }
}
