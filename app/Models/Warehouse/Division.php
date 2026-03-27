<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;
    
    protected $table = 'division';

    protected $fillable = ['name'];

    public $timestamps = false;
}
