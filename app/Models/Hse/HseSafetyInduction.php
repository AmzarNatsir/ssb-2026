<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hse\HseJobSafetyAnalisis;
use App\Models\Hse\HseTestPemahamanSafety;

class HseSafetyInduction extends Model
{
    protected $table = "hse_safety_induction";
    protected $fillable = [
        'nik_karyawan',
        'nik_karyawan_opt',
        'file_surat_pengantar',
        'file_form_induksi',
        'file_dokumentasi_1',
        'file_dokumentasi_2',
        'file_dokumentasi_3',
        'created_by',
        'updated_by',
        'jsa_id',
        'test_pemahaman_id'
    ];

    protected $casts = [
        'nik_karyawan_opt' => 'array',
    ];

    public function jsa(){
        return $this->belongsTo(HseJobSafetyAnalisis::class, 'jsa_id');
    }

    public function testPemahaman(){
        return $this->belongsTo(HseTestPemahamanSafety::class, 'test_pemahaman_id');
    }

}
