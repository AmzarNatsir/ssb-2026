<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class MstHseSlaKategori extends Model
{
    protected $table = 'mst_hse_sla_kategori';
    protected $fillable = [
        'name',
        'label',
        'items',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
