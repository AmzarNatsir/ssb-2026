<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HsePlanLimbah extends Model {
    protected $table = 'hse_plan_limbah';
    protected $fillable = ['tgl_plan','id_limbah','qty','harga_satuan','sub_total','keterangan'];

    public function limbah(){
        return $this->belongsTo('App\Models\Hse\MstHseLimbah','id_limbah');
    }

    public function realisasi(){
        return $this->belongsTo('App\Models\Hse\HseRealisasiLimbah','id','id_plan_limbah');
    }
}
