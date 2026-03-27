<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hse\MstHseLimbah;
use App\Models\Hse\MstHsePerusahaanAngkutan;
use App\Models\Hse\HsePlanLimbah;

class HseRealisasiLimbah extends Model
{
    protected $table = 'hse_realisasi_limbah';
    protected $fillable = [
        'id_plan_limbah',
        'id_limbah',
        'id_prsh_jasa_angkutan',
        'tgl_realisasi',
        'qty',
        'harga_satuan',
        'sub_total',
        'keterangan'
    ];

    public function plan(){
        return $this->belongsTo(HsePlanLimbah::class, 'id_plan_limbah');
    }

    public function limbah(){
        return $this->belongsTo(MstHseLimbah::class, 'id_limbah');
    }

    public function perusahaan_angkutan(){
        return $this->belongsTo(MstHsePerusahaanAngkutan::class, 'id_prsh_jasa_angkutan');
    }
}
