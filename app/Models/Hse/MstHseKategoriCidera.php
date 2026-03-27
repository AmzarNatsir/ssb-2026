<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstHseKategoriCidera extends Model
{
    protected $table = 'mst_hse_kategori_cidera';
    protected $fillable = ['name'];

    public function cidera(){
        return $this->hasMany('App\Models\Hse\MstHseCidera', 'id_kategori_cidera');
    }
}
