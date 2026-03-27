<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;
    
    protected $table = 'currency';

    protected $fillable = ['name', 'code', 'symbol'];

    public $timestamps = false;
}
