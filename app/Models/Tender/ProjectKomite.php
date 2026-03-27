<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class ProjectKomite extends Model
{
    protected $table = "project_komite";
    protected $fillable = ['karyawan_id','created_by','updated_by','approval_order','active'];

    public function karyawan(){
    	return $this->belongsTo('App\Models\HRD\KaryawanModel', 'karyawan_id');
    }
}
