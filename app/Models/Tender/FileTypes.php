<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class FileTypes extends Model
{
    protected $table = "file_types";
    protected $fillable = ['name'];

    public function files()
    {
        return $this->belongsTo(Files::class, 'id', 'file_types_id');
    }

    public function category()
    {    	
    	return $this->belongsTo(FileTypesCategory::class, 'file_types_category_id');
    }
}
