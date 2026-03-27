<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    public $timestamps = false;
    protected $table = "tmgs_project_files";
    protected $fillable = [
        'project_file_id',
        'tender_id',
        'file'
    ];

    public function file(){
    	return $this->belongsTo(Files::class, 'files_id');
    }
}
