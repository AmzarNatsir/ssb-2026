<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class HseBapLimbah extends Model
{
    protected $table = 'hse_bap_limbah';
    protected $fillable = ['no_bap','tgl_bap','user_id'];
}
