<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $fillable = ['location_name'];
    public $timestamps = true;
}
