<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstHseLimbah extends Model
{
    protected $table = "mst_hse_limbah";
    protected $fillable = ['nama','harga_satuan','unit_id','kode','jenis_limbah'];

    public function unit(){
       return $this->belongsTo('App\Models\Hse\MstHseUnitLimbah', 'unit_id');
    }
}
