<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class KaryawanModel extends Model
{
    protected $table = "hrd_karyawan";
    protected $fillable = ["nik_auto", "nik", "nm_lengkap", "tmp_lahir", "tgl_lahir", "jenkel", "no_ktp", "alamat", "notelp", "nmemail", "suku", "agama", "pendidikan_akhir", "status_nikah", "no_npwp", "no_bpjstk", "no_bpjsks", "photo", "tgl_masuk", "id_divisi", "id_departemen", "id_subdepartemen", "id_jabatan", "id_status_karyawan", "tgl_sts_efektif_mulai", "tgl_sts_efektif_akhir", "gaji_pokok", "tunjangan", "id_bank", "no_rekening", "tmt_jabatan", "nik_lama", "gol_darah", "status_lain", "gaji_bpjs", "gaji_jamsostek", "id_finger", "sp_active", "sp_level_active", "sp_lama_active", "sp_mulai_active", "sp_akhir_active", 'sp_reff', 'evaluasi_kerja', 'kategori_evaluasi_kerja', 'cuti', 'izin', 'pelatihan', 'perdis', 'tgl_resign', 'jabatan_awal', 'id_status_tanggungan', 'bpjs_kesehatan', 'bpjs_tk_jht', 'bpjs_tk_jkk', 'bpjs_tk_jkm', 'bpjs_tk_jp'];

    public function get_divisi()
    {
        return $this->belongsTo('App\Models\HRD\DivisiModel', 'id_divisi', 'id');
    }
    public function get_departemen()
    {
        return $this->belongsTo('App\Models\HRD\DepartemenModel', 'id_departemen', 'id');
    }
    public function get_subdepartemen()
    {
        return $this->belongsTo('App\Models\HRD\SubDepartemenModel', 'id_subdepartemen', 'id');
    }
    public function get_jabatan()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'id_jabatan', 'id');
    }

    public function get_jabatan_awal()
    {
        return $this->belongsTo('App\Models\HRD\JabatanModel', 'jabatan_awal', 'id');
    }

    public function get_status_tanggungan()
    {
        return $this->belongsTo('App\Models\HRD\StatusTanggunganModel', 'id_status_tanggungan', 'id');
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

    public function get_potongan_karyawan()
    {
        return $this->hasMany('App\Models\HRD\PotonganGajiKaryawanModel', 'id_karyawan');
    }

    public function user()
    {
        return $this->belongsTo('App\User','nik','nik');
    }

    public function all_karyawan()
    {
        return DB::table("hrd_karyawan")
        ->leftJoin("mst_hrd_jabatan", "hrd_karyawan.id_jabatan", "=", "mst_hrd_jabatan.id")
        ->leftJoin("mst_hrd_sub_departemen", "hrd_karyawan.id_subdepartemen", "=", "mst_hrd_sub_departemen.id")
        ->leftJoin("mst_hrd_departemen", "hrd_karyawan.id_departemen", "=", "mst_hrd_departemen.id")
        ->leftJoin("mst_hrd_divisi", "hrd_karyawan.id_divisi", "=", "mst_hrd_divisi.id")
        ->select("hrd_karyawan.*", "mst_hrd_jabatan.nm_jabatan", "mst_hrd_sub_departemen.nm_subdept", "mst_hrd_departemen.nm_dept", "mst_hrd_divisi.nm_divisi")
        ->where("hrd_karyawan.nik", "<>", "999999999")
        ->whereIn("hrd_karyawan.id_status_karyawan", [1, 2, 3, 7])
        ->orderby("mst_hrd_jabatan.id_level")
        ->get();
    }

    public function all_karyawan_per_dept($id_departemen)
    {
        return DB::table("hrd_karyawan")
        ->leftJoin("mst_hrd_jabatan", "hrd_karyawan.id_jabatan", "=", "mst_hrd_jabatan.id")
        ->leftJoin("mst_hrd_sub_departemen", "hrd_karyawan.id_subdepartemen", "=", "mst_hrd_sub_departemen.id")
        ->leftJoin("mst_hrd_departemen", "hrd_karyawan.id_departemen", "=", "mst_hrd_departemen.id")
        ->leftJoin("mst_hrd_divisi", "hrd_karyawan.id_divisi", "=", "mst_hrd_divisi.id")
        ->select("hrd_karyawan.*", "mst_hrd_jabatan.nm_jabatan", "mst_hrd_sub_departemen.nm_subdept", "mst_hrd_departemen.nm_dept", "mst_hrd_divisi.nm_divisi")
        ->where("hrd_karyawan.nik", "<>", "999999999")
        ->whereIn("hrd_karyawan.id_status_karyawan", [1, 2, 3, 7])
        ->where("hrd_karyawan.id_departemen", $id_departemen)
        ->orderby("mst_hrd_jabatan.id_level")
        ->get();
    }

    public function profil($id)
    {
        return DB::table("hrd_karyawan")
                    ->leftJoin("mst_hrd_jabatan", "hrd_karyawan.id_jabatan", "=", "mst_hrd_jabatan.id")
                    ->leftJoin("mst_hrd_sub_departemen", "hrd_karyawan.id_subdepartemen", "=", "mst_hrd_sub_departemen.id")
                    ->leftJoin("mst_hrd_departemen", "hrd_karyawan.id_departemen", "=", "mst_hrd_departemen.id")
                    ->leftJoin("mst_hrd_divisi", "hrd_karyawan.id_divisi", "=", "mst_hrd_divisi.id")
                    ->leftJoin("mst_hrd_bank", "hrd_karyawan.id_bank", "=", "mst_hrd_bank.id")
                    ->select("hrd_karyawan.*", "mst_hrd_jabatan.nm_jabatan", "mst_hrd_sub_departemen.nm_subdept", "mst_hrd_departemen.nm_dept", "mst_hrd_divisi.nm_divisi", "mst_hrd_bank.nm_bank")
                    ->where("hrd_karyawan.id", $id)
                    ->get()->first();
    }
    public function get_nama_atasan_langsung($id)
    {
        return DB::table("hrd_karyawan")
                    ->where("hrd_karyawan.id_jabatan", $id)
                    ->get()->first();
    }
    public function get_nama_atasan_tidak_langsung($id)
    {
        return DB::table("hrd_karyawan")
                    ->where("hrd_karyawan.id_jabatan", $id)
                    ->get()->first();
    }

    function superior()
    {
        $superiors = array();
        $superior = $this->get_jabatan->get_id_gakom()->get_karyawan();
        if ($superior->get_jabatan->get_id_gakom()->get_karyawan() == is_null()) {
        return $superior;
        } else{
        return $superior->superior();
        }
    }

    public function get_jenis_sp()
    {
        return $this->belongsTo("App\Models\HRD\JenisSPModel", 'sp_level_active', 'id');
    }
    public function get_detail_sp()
    {
        return $this->belongsTo("App\Models\HRD\SuratPeringatanModel", 'sp_reff', 'id');
    }
}
