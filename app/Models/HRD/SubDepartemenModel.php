<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class SubDepartemenModel extends Model
{
    protected $table = "mst_hrd_sub_departemen";
    protected $fillable = ["id_divisi", "id_dept", "nm_subdept"];

    public function departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_dept', 'id');
    }
    public function divisi()
    {
        return $this->belongsTo('App\Models\HRD\DivisiModel', 'id_divisi', 'id');
    }
}
