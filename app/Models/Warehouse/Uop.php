<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uop extends Model
{
    use SoftDeletes;
    
    protected $table = 'uop';

    protected $fillable = ['name', 'description'];

    public $timestamps = false;
}
