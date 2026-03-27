<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Config;

class PelamarModel extends Model
{
    protected $table = "hrd_recr_pelamar";
    protected $fillable = ['no_identitas', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenkel', 'id_agama', 'alamat', 'no_hp', 'no_wa', 'email', 'file_photo', 'status', 'id_departemen', 'id_sub_departemen', 'id_jabatan', 'id_lowongan', 'status_nikah', 'id_jenjang', 'no_surat_pengantar', 'tgl_surat_pengantar', 'surat_by', 'hrd_by', 'id_karyawan', 'no_surat_si', 'tgl_surat_si', 'id_perubahan_status', 'approval_key', 'status_pengajuan', 'current_approval_id', 'is_draft', 'psikotes_nilai', 'psikotes_ket', 'psikotes_kesimpulan', 'wawancara_nilai', 'wawancara_ket', 'wawancara_kesimpulan', 'total_skor', 'status_app'];

    public function get_departmen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', "id_departemen", "id");
    }

    public function get_sub_departemen()
    {
        return $this->belongsTo("App\Models\HRD\SubDepartemenModel", "id_sub_departemen", "id");
    }

    public function get_jabatan()
    {
        return $this->belongsTo("App\Models\HRD\JabatanModel", "id_jabatan", "id");
    }

    public function get_list_persetujuan()
    {
        return $this->hasMany('App\Models\HRD\RecruitmentPersetujuanModel', 'id_pelamar');
    }

    public function get_nik_karyawan_baru()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }

    public function get_create_by($id)
    {
        // return $this->belongsTo('App\User', 'surat_by', 'id');


       return \DB::table('users')->where('users.id', $id)
        ->leftjoin('hrd_karyawan', 'users.nik', '=', 'hrd_karyawan.nik')
        ->leftjoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
        ->select('hrd_karyawan.nm_lengkap', 'mst_hrd_jabatan.nm_jabatan')->get()->first();


    }

    public function get_hrd_by($id)
    {
        return \DB::table('users')->where('users.id', $id)
        ->leftjoin('hrd_karyawan', 'users.nik', '=', 'hrd_karyawan.nik')
        ->leftjoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
        ->select('hrd_karyawan.nm_lengkap', 'mst_hrd_jabatan.nm_jabatan')->get()->first();
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
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
