<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Config;

class MutasiModel extends Model
{
    protected $table = "hrd_mutasi";
    protected $fillable = ["id_karyawan", "no_auto", "no_surat", "tgl_Surat", "kategori", "id_divisi_lm", "id_dept_lm", "id_subdept_lm", "id_jabt_lm", "tgl_efektif_lm", "id_divisi_br", "id_dept_br", "id_subdept_br", "id_jabt_br", "tgl_efektif_br", "keterangan", "id_ttd", "id_user", "tgl_pengajuan", "status_pengajuan", 'diajukan_oleh', 'alasan_pengajuan', 'id_departemen', 'id_persetujuan', 'sts_persetujuan', 'tgl_persetujuan', 'ket_persetujuan', 'id_approval_al', 'status_approval_al', 'tanggal_approval_al', 'desk_approval_al', 'approval_key', 'current_approval_id', 'is_draft', 'file_hasil_evaluasi'];

    public function get_profil()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_karyawan', 'id');
    }
    public function get_status_karyawan($id)
    {
        $list_status = Config::get('constants.status_karyawan');
        foreach($list_status as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }
    public function get_departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_departemen', 'id');
    }

    public function get_divisi_lama()
    {
        return $this->belongsTo('App\Models\HRD\DivisiModel', 'id_divisi_lm', 'id');
    }
    public function get_dept_lama()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_dept_lm', 'id');
    }
    public function get_subdept_lama()
    {
        return $this->belongsTo('App\Models\HRD\SubDepartemenModel', 'id_subdept_lm', 'id');
    }
    public function get_jabatan_lama()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'id_jabt_lm', 'id');
    }
    public function get_divisi_baru()
    {
        return $this->belongsTo('App\Models\HRD\DivisiModel', 'id_divisi_br', 'id');
    }
    public function get_dept_baru()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_dept_br', 'id');
    }
    public function get_subdept_baru()
    {
        return $this->belongsTo('App\Models\HRD\SubDepartemenModel', 'id_subdept_br', 'id');
    }
    public function get_jabatan_baru()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'id_jabt_br', 'id');
    }
    public function get_approver_al()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_approval_al', 'id');
    }
    public function get_approver()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'id_persetujuan', 'id');
    }

    public function get_submit_by()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'diajukan_oleh', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }
}
