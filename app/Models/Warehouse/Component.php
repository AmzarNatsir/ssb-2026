<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use SoftDeletes;
    
    protected $table = 'component';

    protected $fillable = ['name'];

    public $timestamps = false;
}
