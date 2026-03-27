<?php
namespace App\Helpers;

use App\Models\HRD\ApprovalModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\JenisSPModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\MutasiModel;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\PerubahanStatusModel;
use App\Models\HRD\PinjamanKaryawanModel;
use App\Models\HRD\PinjamanKaryawanMutasiModel;
use Illuminate\Support\Facades\DB;
use App\Models\HRD\SetupPersetujuanModel;
use App\Models\HRD\SetupHariLiburModel;
use App\Models\HRD\ProfilPerusahaanModel;
use App\Models\HRD\RecruitmentPengajuanTKModel;
use App\Models\HRD\RefApprovalDetailModel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Config;
use DateTime;
use Illuminate\Support\Facades\Storage;

class Hrdhelper
{
    public static function get_profil_perusahaan()
    {
        $result = ProfilPerusahaanModel::first();
        return $result;
    }
    public static function get_status_karyawan($id_status)
    {
        $list_status = Config::get('constants.status_karyawan');
        foreach($list_status as $key => $value)
        {
            if($key==$id_status)
            {
                return $value;
                break;
            }
        }
    }
    public static function selisih_hari($tanggal1, $tanggal2)
    {
        //ambil hari libur nasional
        $thn_skr = date('Y');
        $list_tanggal_libur = SetupHariLiburModel::where('tahun', $thn_skr)->get();
        $jml_hari_libur = count($list_tanggal_libur);

        $pecah1 = explode("-", $tanggal1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        //tgl kedua
        $pecah2 = explode("-", $tanggal2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];
        // mencari selisih hari dari tanggal awal dan akhir
        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = ($jd2 - $jd1) + 1;
        $libur=0;
        $libur_nasional=0;
        for($i=1; $i<=$selisih; $i++){
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            // yang merupakan hari minggu
            if ((date("N", $tanggal) == 7)){
                $libur++;
            }
            if($jml_hari_libur>0)
            {
                foreach($list_tanggal_libur as $list)
                {
                    if($list['tanggal']==date("Y-m-d", $tanggal))
                    {
                        $libur_nasional++;
                    }
                }
            }
        }
        return $selisih - $libur - $libur_nasional;
    }
    public static function get_level_persetujuan_atasan_langsung()
    {
        $res = SetupPersetujuanModel::find(1);
        $lvl_persetujuan = $res->lvl_persetujuan;
        return $lvl_persetujuan;
    }
    public static function get_level_persetujuan_hrd_modul_cuti()
    {
        $res = SetupPersetujuanModel::find(1);
        if(empty($res->id_dept_manager_hrd)) {
            $id_jabatan_hrd = 0;
        } else {
            $id_jabatan_hrd = $res->id_dept_manager_hrd;
        }
        return $id_jabatan_hrd;
    }
    public static function get_level_persetujuan_atasan_langsung_permintaan_tk()
    {
        $res = SetupPersetujuanModel::find(2);
        $lvl_persetujuan = $res->lvl_persetujuan;
        return $lvl_persetujuan;
    }
    public static function get_level_persetujuan_hrd_permintaan_tk()
    {
        $res = SetupPersetujuanModel::find(2);
        $id_jabatan_hrd = $res->id_dept_manager_hrd;
        return $id_jabatan_hrd;
    }
    public static function get_nama_bulan($bln)
    {
        $list_bulan = Config::get("constants.bulan");
        foreach($list_bulan as $key => $value)
        {
            if($key==$bln)
            {
                $ket_bulan = $value;
                break;
            }
        }
        return $ket_bulan;
    }
    public static function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public static function get_permission_user($id_role)
    {
        //foreach(auth()->user()->roles->pluck('id') as $val){
        //    $id_role = $val;
        //}
        //$id_role = auth()->user()->roles->pluck('id');
        $roles = Role::find($id_role);
        //$permission = PermissionhasRole::all();
        $permission_roles = $roles->permissions;

        //$roles = Role::find()->getAllPermissions();
        return $permission_roles;
        //$data['user'] = $permission_roles;
    }
    public static function check_permission_user($string, $id_role)
    {
        $roles = Role::with('permissions')->find($id_role);
        $permission_roles = $roles->permissions;
        $checked="";
        foreach ($permission_roles as $item => $value)
        {
            if($value->name==$string){
                $checked = "checked";
            }
        }
        return $checked;
    }
    public static function get_bulan_romawi($bln)
    {
        switch($bln) {
            case '01' :
                $bln_huruf = "I";
            break;
            case '02' :
                $bln_huruf = "II";
            break;
            case '03' :
                $bln_huruf = "III";
            break;
            case '04' :
                $bln_huruf = "IV";
            break;
            case '05' :
                $bln_huruf = "V";
            break;
            case '06' :
                $bln_huruf = "VI";
            break;
            case '07' :
                $bln_huruf = "VII";
            break;
            case '08' :
                $bln_huruf = "VIII";
            break;
            case '09' :
                $bln_huruf = "IX";
            break;
            case '10' :
                $bln_huruf = "X";
            break;
            case '11' :
                $bln_huruf = "XI";
            break;
            case '12' :
                $bln_huruf = "XII";
            break;
            default:
                $bln_huruf = "Tidak di ketahui";
            break;
        }
        return $bln_huruf;
    }
    public static function get_list_hari()
    {
        $arr_hari = array(
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
        );
        return $arr_hari;
    }
    public static function get_tanggal_pelaksanaan($tgl1, $tgl2, $hari1, $hari2)
    {
        $arr_tgl_1 = explode("-", $tgl1);
        $tgl_1 = $arr_tgl_1[2];
        $bln_1 = $arr_tgl_1[1];
        $thn_1 = $arr_tgl_1[0];

        $arr_tgl_2 = explode("-", $tgl2);
        $tgl_2 = $arr_tgl_2[2];
        $bln_2 = $arr_tgl_2[1];
        $thn_2 = $arr_tgl_2[0];

        if($tgl1==$tgl2)
        {
            $ket_tgl_pelaksanaan = $tgl_1." ".Hrdhelper::get_nama_bulan($bln_1)." ".$thn_1;
        } else {
            if($bln_1==$bln_2 && $thn_1==$thn_2)
            {
                if($tgl_1==$tgl_2)
                {
                    $ket_tgl_pelaksanaan = $tgl_1."-".$tgl_2." ".Hrdhelper::get_nama_bulan($bln_1)." ".$thn_1;
                } else {
                    $ket_tgl_pelaksanaan = $tgl_1."-".$tgl_2." ".Hrdhelper::get_nama_bulan($bln_1)." ".$thn_1;
                }
            } else {
                if($thn_1==$thn_2)
                {
                    $ket_tgl_pelaksanaan = $tgl_1." ".Hrdhelper::get_nama_bulan($bln_1)." s/d ".$tgl_2." ".Hrdhelper::get_nama_bulan($bln_2)." ".$thn_1;
                } else {
                    $ket_tgl_pelaksanaan = $tgl_1." ".Hrdhelper::get_nama_bulan($bln_1)." ".$thn_1." s/d ".$tgl_2." ".Hrdhelper::get_nama_bulan($bln_2)." ".$thn_2;
                }
            }
        }
        return $ket_tgl_pelaksanaan;

    }
    public static function tglAkhirBulan($thn,$bln)
    {
        $bulan['01']='31';
        $bulan['02']='28';
        $bulan['03']='31';
        $bulan['04']='30';
        $bulan['05']='31';
        $bulan['06']='30';
        $bulan['07']='31';
        $bulan['08']='31';
        $bulan['09']='30';
        $bulan[10]='31';
        $bulan[11]='30';
        $bulan[12]='31';

        if ($thn%4==0 || $thn==2016){
            $bulan['02']='29';
        }
        return $bulan[$bln];
    }

    public static function isWeekend($date) {
        $date1 = strtotime($date);
        $date2 = date("l", $date1);
        $weekDay = strtolower($date2);
        return $weekDay;
    }

    public static function get_hari($tanggal)
    {
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }

    public static function get_hari_ini($tanggal)
    {
        $day = date('D', strtotime($tanggal));
        switch($day) {
            case 'Sun' :
                $hari_ina = "Minggu";
            break;
            case 'Mon' :
                $hari_ina = "Senin";
            break;
            case 'Tue' :
                $hari_ina = "Selasa";
            break;
            case 'Wed' :
                $hari_ina = "Rabu";
            break;
            case 'Thu' :
                $hari_ina = "Kamis";
            break;
            case 'Fri' :
                $hari_ina = "Jumat";
            break;
            default:
                $hari_ina = "Sabtu";
            break;
        }
        return $hari_ina;
    }

    public static function get_lama_kerja_karyawan($tgl_mulai)
    {
        $waktuMulai = new DateTime($tgl_mulai);
        $waktuSelesai = new Datetime(date('Y-m-d'));

        $selisihWaktu = $waktuMulai->diff($waktuSelesai);

        return $selisihWaktu->format('%Y tahun, %m bulan, %d hari');
    }

    public static function set_approval_permintaan_tk($id_jabatan, $lvl)
    {
        if($lvl==1)
        {
            $id_jabt_al = JabatanModel::find($id_jabatan)->id_gakom;
            $query_al = KaryawanModel::where('id_jabatan', $id_jabt_al)->first();
            if(!empty($query_al->id))
            {
                $id_al = $query_al->id;
            } else {
                $id_al = NULL;
            }
            $id_karyawan = $id_al;
        } elseif($lvl==2) {
            $id_jabt_al = JabatanModel::find($id_jabatan)->id_gakom;
            $id_jabt_atl = JabatanModel::find($id_jabt_al)->id_gakom;
            $query_atl = KaryawanModel::where('id_jabatan', $id_jabt_atl)->first();
            if(!empty($query_atl->id))
            {
                $id_atl = $query_atl->id;
            } else {
                $id_atl = NULL;
            }
            $id_karyawan = $id_atl;
        } else {
            //manajer psdm/hrd (13)
            $query_psdm = KaryawanModel::where('id_jabatan', 13)->first();
            if(!empty($query_psdm->id))
            {
                $id_psdm = $query_psdm->id;
            } else {
                $id_psdm = NULL;
            }
            $id_karyawan = $id_psdm;
        }

        return $id_karyawan;

        // return $nm_al;
    }

    public static function set_approval($id_jabatan, $lvl)
    {
       if($lvl==2) {
            $id_jabt_al = JabatanModel::find($id_jabatan)->id_gakom;
            $query_atl = KaryawanModel::where('id_jabatan', $id_jabt_al)->first();
            if(!empty($query_atl->id))
            {
                $id_atl = $query_atl->id;
            } else {
                $id_atl = NULL;
            }
            $id_karyawan = $id_atl;
        } else {
            //manajer psdm/hrd (13)
            $query_psdm = KaryawanModel::where('id_jabatan', 13)->first();
            if(!empty($query_psdm->id))
            {
                $id_psdm = $query_psdm->id;
            } else {
                $id_psdm = NULL;
            }
            $id_karyawan = $id_psdm;
        }

        return $id_karyawan;

        // return $nm_al;
    }

    public static function set_approval_cek($group, $dept)
    {
        $queryCheck = RefApprovalDetailModel::where('approval_group', $group)->where('approval_departemen', $dept)->get()->count();
        return $queryCheck;
    }

    public static function set_approval_get_first($group, $dept)
    {
        $getFirst = RefApprovalDetailModel::where('approval_group', $group)->where('approval_departemen', $dept)->orderBy('approval_level', 'asc')->first()->approval_by_employee;
        return $getFirst;
    }

    public static function set_approval_new($group, $dept)
    {
        $queryAll = RefApprovalDetailModel::where('approval_group', $group)->where('approval_departemen', $dept)->get();
        return $queryAll;
    }

    public static function set_approval_hrd($id_gakom)
    {
        $dept_psdm = 13;
        $arr_approval = array();
        $query1 = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        if(!empty($query1->id)) {
            //Level 1
            $start_level = $query1->get_jabatan->mst_level_jabatan->level;
            $id_gakom_next = $query1->get_jabatan->id_gakom;
            $arr_approval[] = [
                'id_employee' => $query1->id,
                'level_approval' => 1,
                'id_gakom' => $id_gakom_next,
                'level_jabatan' => $start_level
            ];
            $lvl_appr = 1;
            for($i=$start_level; $i>=2; $i--)
            {
                if(!empty($id_gakom_next))
                {
                    $query_next = KaryawanModel::where('id_jabatan', $id_gakom_next)->first();
                    if(!empty($query_next->id)) {
                        $lvl_appr++;
                        $arr_approval[] = [
                            'id_employee' => $query_next->id,
                            'level_approval' => $lvl_appr,
                            'id_gakom' => $query_next->get_jabatan->id_gakom,
                            'level_jabatan' => $query_next->get_jabatan->mst_level_jabatan->level
                        ];
                        $id_gakom_next = $query_next->get_jabatan->id_gakom;
                    }
                }
            }
            $queryhrd = KaryawanModel::where('id_jabatan', $dept_psdm)->first();
            $arr_approval[] = [
                'id_employee' => $queryhrd->id,
                'level_approval' => $lvl_appr + 1,
                'id_gakom' => 0,
                'level_jabatan' => 0
            ];
        }
        return $arr_approval;
    }

    public static function get_approval_pelatihan($id_gakom)
    {
        $query1 = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        if(!empty($query1->id)) {
            //Level 1
            $start_level = $query1->get_jabatan->mst_level_jabatan->level;
            $id_gakom_next = $query1->get_jabatan->id_gakom;
            $arr_approval[] = [
                'id_employee' => $query1->id,
                'level_approval' => 1,
                'id_gakom' => $id_gakom_next,
                'level_jabatan' => $start_level
            ];
            $lvl_appr = 1;
            for($i=$start_level; $i>=2; $i--)
            {
                if(!empty($id_gakom_next))
                {
                    $query_next = KaryawanModel::where('id_jabatan', $id_gakom_next)->first();
                    if(!empty($query_next->id)) {
                        $lvl_appr++;
                        $arr_approval[] = [
                            'id_employee' => $query_next->id,
                            'level_approval' => $lvl_appr,
                            'id_gakom' => $query_next->get_jabatan->id_gakom,
                            'level_jabatan' => $query_next->get_jabatan->mst_level_jabatan->level
                        ];
                        $id_gakom_next = $query_next->get_jabatan->id_gakom;
                    }
                }
            }
        }
        return $arr_approval;
    }

    public static function get_approval_penggajian($id_gakom)
    {
        $dept_psdm = 13;
        $query1 = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        if(!empty($query1->id)) {
            //Level 2
            $start_level = $query1->get_jabatan->mst_level_jabatan->level;
            $id_gakom_next = $query1->get_jabatan->id_gakom;
            $arr_approval[] = [
                'id_employee' => $query1->id,
                'level_approval' => 2,
                'id_gakom' => $id_gakom_next,
                'level_jabatan' => $start_level
            ];
            $lvl_appr = 2;
            for($i=$start_level; $i>=2; $i--)
            {
                if(!empty($id_gakom_next))
                {
                    $query_next = KaryawanModel::where('id_jabatan', $id_gakom_next)->first();
                    if(!empty($query_next->id)) {
                        $lvl_appr++;
                        $arr_approval[] = [
                            'id_employee' => $query_next->id,
                            'level_approval' => $lvl_appr,
                            'id_gakom' => $query_next->get_jabatan->id_gakom,
                            'level_jabatan' => $query_next->get_jabatan->mst_level_jabatan->level
                        ];
                        $id_gakom_next = $query_next->get_jabatan->id_gakom;
                    }
                }
            }
        }
        $queryhrd = KaryawanModel::where('id_jabatan', $dept_psdm)->first();
            $arr_approval[] = [
                'id_employee' => $queryhrd->id,
                'level_approval' => 1,
                'id_gakom' => 0,
                'level_jabatan' => 0
            ];
        return $arr_approval;
    }

    public static function get_notif_approval()
    {
        $id_user = auth()->user()->karyawan->id;
        $queryNotif = ApprovalModel::where('approval_active', 1)->where('approval_by_employee', $id_user)->get();

        $tot_1 = ApprovalModel::where('approval_group', 1)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_1_ket = "Pengajuan Permintaan Tenaga Kerja";
        $tot_2 = ApprovalModel::where('approval_group', 2)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_2_ket = "Pengajuan Aplikasi Pelamar";
        $tot_3 = ApprovalModel::where('approval_group', 3)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_3_ket = "Pengajuan Cuti";
        $tot_4 = ApprovalModel::where('approval_group', 4)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_4_ket = "Pengajuan Izin";
        $tot_5 = ApprovalModel::where('approval_group', 5)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_5_ket = "Pengajuan Perubahan Status";
        $tot_6 = ApprovalModel::where('approval_group', 6)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_6_ket = "Pengajuan Mutasi";
        $tot_7 = ApprovalModel::where('approval_group', 7)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_7_ket = "Pengajuan Lembur";
        $tot_8 = ApprovalModel::where('approval_group', 8)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_8_ket = "Pengajuan Perjalanan Dinas";
        $tot_9 = ApprovalModel::where('approval_group', 9)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_9_ket = "Pengajuan Pelatihan";
        $tot_10 = ApprovalModel::where('approval_group', 10)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_10_ket = "Pengajuan Surat Teguran";
        $tot_11 = ApprovalModel::where('approval_group', 11)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_11_ket = "Pengajuan Surat Peringatan";
        $tot_12 = ApprovalModel::where('approval_group', 12)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_12_ket = "Pengajuan Penggajian";
        $tot_13 = ApprovalModel::where('approval_group', 13)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_13_ket = "Pengajuan Pinjaman Karyawan";
        $tot_14 = ApprovalModel::where('approval_group', 14)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_14_ket = "Pengajuan Perubahan Masa Cuti";
        $tot_15 = ApprovalModel::where('approval_group', 15)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_15_ket = "Pengajuan Resign";
        $tot_16 = ApprovalModel::where('approval_group', 16)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_16_ket = "Pengajuan Form Exit Interviews";
        $tot_17 = ApprovalModel::where('approval_group', 17)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_17_ket = "Pengajuan Penonaktifan Surat Peringatan";
        $tot_18 = ApprovalModel::where('approval_group', 18)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_18_ket = "Pengajuan Tunjangan Hari Raya";
        $tot_19 = ApprovalModel::where('approval_group', 19)->where('approval_active', 1)->where('approval_by_employee', $id_user)->get()->count();
        $tot_19_ket = "Penilaian KPI Departemen";

        $total_appr = $queryNotif->count();

        $html = '<a href="#" class="search-toggle iq-waves-effect">
        <i class="ri-notification-2-line"></i>
        <span class="badge badge-pill badge-danger badge-up count-mail">'.$total_appr.'</span>
        </a>
        <div class="iq-sub-dropdown">
            <div class="iq-card shadow-none m-0">
                <div class="iq-card-body p-0 ">
                    <div class="bg-danger p-3">
                        <h5 class="mb-0 text-white">All Notifications<small
                                class="badge  badge-light float-right pt-1">'.$total_appr.'</small></h5>
                    </div>';
        if($total_appr > 0) {
        $html .= '<a href='.url("hrd/persetujuan").' class="iq-sub-card" >
                <div class="media align-items-center">
                <div class="media-body ml-3">';
                    if($tot_1 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_1_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_1.'</small></h6><hr>';
                    }
                    if($tot_2 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_2_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_2.'</small></h6><hr>';
                    }
                    if($tot_3 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_3_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_3.'</small></h6><hr>';
                    }
                    if($tot_4 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_4_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_4.'</small></h6><hr>';
                    }
                    if($tot_5 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_5_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_5.'</small></h6><hr>';
                    }
                    if($tot_6 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_6_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_6.'</small></h6><hr>';
                    }
                    if($tot_7 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_7_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_7.'</small></h6><hr>';
                    }
                    if($tot_8 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_8_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_8.'</small></h6><hr>';
                    }
                    if($tot_9 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_9_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_9.'</small></h6><hr>';
                    }
                    if($tot_10 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_10_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_10.'</small></h6><hr>';
                    }
                    if($tot_11 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_11_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_11.'</small></h6><hr>';
                    }
                    if($tot_12> 0) {
                        $html .= '<h6 class="mb-0">'.$tot_12_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_12.'</small></h6><hr>';
                    }
                    if($tot_13 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_13_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_13.'</small></h6><hr>';
                    }
                    if($tot_14 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_14_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_14.'</small></h6><hr>';
                    }
                    if($tot_15 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_15_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_15.'</small></h6><hr>';
                    }
                    if($tot_16 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_16_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_16.'</small></h6><hr>';
                    }
                    if($tot_17 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_17_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_17.'</small></h6><hr>';
                    }
                    if($tot_18 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_18_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_18.'</small></h6><hr>';
                    }
                    if($tot_19 > 0) {
                        $html .= '<h6 class="mb-0">'.$tot_19_ket.'<small class="badge  badge-light float-right pt-1">'.$tot_19.'</small></h6><hr>';
                    }
        $html .= '</div>
                </div>
            </a>';
        }
        $html .='</div>
            </div>
        </div>';
        echo $html;
    }

    public static function get_masa_berlaku_sp($jenis_sp)
    {
        $master = JenisSPModel::find($jenis_sp);
        $masa_berlaku = ($master->lama_berlaku); //6 bulan
        return $masa_berlaku;
    }

    public static function get_umur_karyawan($tgl_lahir)
    {
        $tgl_lahir = new DateTime($tgl_lahir);
        $hari_ini = new Datetime(date('Y-m-d'));

        $selisihWaktu = $tgl_lahir->diff($hari_ini);

        return $selisihWaktu->format('%Y');
        // return $selisihWaktu->format('%Y tahun, %m bulan, %d hari');
    }

    public static function get_kop_surat()
    {
        $result = ProfilPerusahaanModel::first();
        $logo = "";
        if($result) {
            if(!empty($result->logo_perusahaan)) {
                $logo = $result->logo_perusahaan;
            }
        }
        $data = [
            'alamat_situs' => "https://pt-ssb.co.id",
            'lokasi' => "POMALAA - KOLAKA - SULAWESI TENGGARA - INDONESIA",
            'logo' => $logo
        ];
        return $data;
    }

    public static function generate_mutasi($id_head, $total, $tenor)
    {
        $tenor_baru = PinjamanKaryawanMutasiModel::where("id_head", $id_head)->whereNull('status')->get()->count();
        $total_terbayar = PinjamanKaryawanMutasiModel::where('id_head', $id_head)->where('status', 1)
                ->get()
                ->sum(fn($item) => (float) $item->nominal);
        $sisa_outstanding = $total - $total_terbayar;
        $new_angsuran = $sisa_outstanding / $tenor_baru;
        //update mutasi - angsuran baru
        $getData = PinjamanKaryawanMutasiModel::where("id_head", $id_head)->whereNull('status')->get();
        foreach($getData as $r) {
            PinjamanKaryawanMutasiModel::find($r->id)->update([
                "nominal" => $new_angsuran
            ]);
        }
        $update_head = PinjamanKaryawanModel::find($id_head);
        $update_head->angsuran = $new_angsuran; //y = belum lunas, n=lunas
        $update_head->save();
    }

    public static function generate_mutasi_lunas_awal($id_head)
    {
        $getData = PinjamanKaryawanMutasiModel::where("id_head", $id_head)->whereNull('status')->get();
        foreach($getData as $r) {
            PinjamanKaryawanMutasiModel::find($r->id)->update([
                "nominal" => 0
            ]);
        }
    }

    public static function generate_duedate_pinjaman_karyawan($id_head, $tgl_bayar)
    {
        $arr_tgl_bayar = explode("-", $tgl_bayar);
        $tgl_1 = $arr_tgl_bayar[2];
        $bln_1 = $arr_tgl_bayar[1];
        $thn_1 = $arr_tgl_bayar[0];

        if($bln_1==12) {
            $bln_baru = "01";
            $thn_baru = $thn_1 + 1;
        } else {
            $bln_baru = $bln_1 + 1;
            $thn_baru = $thn_1;
        }
        $tgl_jatuh_tempo = $thn_baru."-".$bln_baru."-".$tgl_1;

        $resData = PinjamanKaryawanMutasiModel::where('id_head', $id_head)->where('bayar_aktif', 1)->first();
        PinjamanKaryawanMutasiModel::find($resData->id)->update([
            "tanggal" => $tgl_jatuh_tempo
        ]);
    }

    public static function terbilang($nilai)
    {
        $angka = abs((int) $nilai);
        $huruf = [
            "", "Satu", "Dua", "Tiga", "Empat", "Lima",
            "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
        ];

        $temp = "";
        if ($angka < 12) {
            $temp = " " . $huruf[$angka];
        } else if ($angka < 20) {
            $temp = self::terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $temp = self::terbilang(intval($angka / 10)) . " Puluh " . self::terbilang($angka % 10);
        } else if ($angka < 200) {
            $temp = " Seratus " . self::terbilang($angka - 100);
        } else if ($angka < 1000) {
            $temp = self::terbilang(intval($angka / 100)) . " Ratus " . self::terbilang($angka % 100);
        } else if ($angka < 2000) {
            $temp = " Seribu " . self::terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $temp = self::terbilang(intval($angka / 1000)) . " Ribu " . self::terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $temp = self::terbilang(intval($angka / 1000000)) . " Juta " . self::terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $temp = self::terbilang(intval($angka / 1000000000)) . " Miliar " . self::terbilang($angka % 1000000000);
        } else if ($angka < 1000000000000000) {
            $temp = self::terbilang(intval($angka / 1000000000000)) . " Triliun " . self::terbilang($angka % 1000000000000);
        }

        return trim($temp);
    }
}
