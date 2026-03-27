<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Model;

class InspectionPropertiesInput extends Model
{
    protected $table="inspection_properties_input";
    protected $fillable = ['type'];
}
