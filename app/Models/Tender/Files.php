<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = "files";
    protected $fillable = ['name','desc','file_types_id'];

    public function filetype(){
    	return $this->belongsTo(FileTypes::class, 'file_types_id');
    }    
}
