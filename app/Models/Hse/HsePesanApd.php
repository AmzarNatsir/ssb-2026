<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HsePesanApd extends Model
{
    protected $table = 'hse_apd_order';
    protected $fillable = [
        'tanggal_order',
        'id_apd',
        'id_pengorder',
        'no_order',
        'qty'
    ];
}
