<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseJobSafetyAnalisis extends Model
{
    protected $table = "hse_job_safety_analisis";
    protected $fillable = [
        'no_jsa',
        'no_dokumen',
        'nama_pengawas',
        'nama_pelaksana',
        'lokasi',
        'tanggal_terbit',
        'nama_apd',
        'file_jsa',
        'created_by',
        'updated_by'
    ];

}
