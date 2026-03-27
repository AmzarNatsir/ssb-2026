<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PerdisFasilitasModel extends Model
{
    protected $table = "hrd_perdis_fasilitas";
    protected $fillable = ['id_perdis', 'id_fasilitas', 'hari', 'biaya', 'sub_total', 'file_1', 'file_2', 'realisasi'];

    public function get_master_fasilitas_perdis()
    {
        return $this->belongsTo('App\Models\HRD\FasilitasPerdisModel', 'id_fasilitas', 'id');
    }
}
