<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class FileTypesCategory extends Model
{
    protected $table = "file_types_category";
    protected $fillable = ['name'];    
}
