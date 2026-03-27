<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Config;

class PelamarKeluargaModel extends Model
{
    protected $table = "hrd_recr_keluarga";
    protected $fillable = ['id_pelamar', 'id_hubungan', 'nm_keluarga', 'tmp_lahir', 'tgl_lahir', 'jenkel', 'id_jenjang', 'pekerjaan'];

    public function get_hubungan_keluarga($id)
    {
        $list_hubungan = Config::get('constants.hubungan_keluarga');
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
