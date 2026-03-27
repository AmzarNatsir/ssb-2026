<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class OpsiStatusProject extends Model
{
    public $timestamps = false;
    protected $table = "opsi_status_project";
    protected $fillable = ['status'];
}
