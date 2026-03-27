<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormaPsikotesModel extends Model
{
    use HasFactory;
    protected $table = "hrd_set_norma_psikotes";
    protected $fillable = [
        'skor_min',
        'skor_maks',
        'hasil'
    ];
}
