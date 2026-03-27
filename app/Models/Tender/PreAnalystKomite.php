<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class PreAnalystKomite extends Model
{
    protected $table = "pre_analyst_komite";
    protected $fillable = ['user_id','note'];
}
