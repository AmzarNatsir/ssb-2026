<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Config;

class RiwayatPendidikanModel extends Model
{
    protected $table = "hrd_karyawan_rwyt_pendidikan";
    protected $fillable = ['id_karyawan', 'id_jenjang', 'nm_sekolaj_pt', 'alamat', 'mulai_tahun', 'sampai_tahun', 'file_ijazah'];

    public function get_profil()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }
    public function get_jenjang_pendidikan($id)
    {
        $list_jenjang = Config::get('constants.jenjang_pendidikan');
        foreach($list_jenjang as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }
}
