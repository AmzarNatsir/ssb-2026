<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class MemoModel extends Model
{
    protected $table = "hrd_memo_internal";
    protected $fillable = ['tgl_post', 'judul', 'deskripsi', 'file_memo', 'status', 'id_user', 'departemen_post'];

    public function get_departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'departemen_post', 'id');
    }
}
