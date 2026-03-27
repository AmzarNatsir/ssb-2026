<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class DepartemenModel extends Model
{
    protected $table = "mst_hrd_departemen";
    protected $fillable = ["nm_dept", "id_divisi", "status"];

    public function get_master_divisi()
    {
        return $this->belongsTo('App\Models\HRD\DivisiModel', 'id_divisi', 'id');
    }
}
