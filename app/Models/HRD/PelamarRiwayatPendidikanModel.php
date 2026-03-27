<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Config;

class PelamarRiwayatPendidikanModel extends Model
{
    protected $table = "hrd_recr_riwayat_pendidikan";
    protected $fillable = ["id_pelamar", "id_jenjang", "nm_sekolah_pt", "alamat", "mulai_tahun", "sampai_tahun"];

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
