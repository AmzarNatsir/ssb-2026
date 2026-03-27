<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseTestPemahamanSafety extends Model
{
    protected $table = "hse_test_pemahaman_safety";
    protected $fillable = [
        'nik_karyawan',
        'no_dokumen',
        'file_quesioner',
        'created_by',
        'updated_by'
    ];

}
