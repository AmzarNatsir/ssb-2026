<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Config;

class LBKeluargaModel extends Model
{
    protected $table = "hrd_karyawan_lb_keluarga";
    protected $fillable = ["id_karyawan", "id_hubungan", "nm_keluarga", "tmp_lahir", "tgl_lahir", "jenkel", "id_jenjang", "pekerjaan"];

    public function get_profil()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_hubungan_keluarga($id)
    {
        $list_hubungan = Config::get('constants.hubungan_lbkeluarga');
        foreach($list_hubungan as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }
    public function get_pendidikan_akhir($id)
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
