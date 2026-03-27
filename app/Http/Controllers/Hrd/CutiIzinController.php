<?php

namespace App\Http\Controllers\Hrd;

use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\JenisCutiIzinModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;
use Illuminate\Support\Str;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\CutiPerubahanModel;

class CutiIzinController extends Controller
{

    private $dept_psdm = 13;

    public function index()
    {
        $now = date('y-m-d');
        $data['count_pengajuan_cuti'] = CutiModel::where('sts_pengajuan', 1)->get()->count();
        $data['count_pengajuan_izin'] = IzinModel::where('sts_pengajuan', 1)->get()->count();

        $data['count_izin_hari_ini'] = IzinModel::where('sts_pengajuan', 2)->where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get()->count();
        $data['count_cuti_hari_ini'] = CutiModel::where('sts_pengajuan', 2)->where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get()->count();

        $data['all_izin_hari_ini'] = IzinModel::where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get();
        $data['all_cuti_hari_ini'] = CutiModel::where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get();

        $data['count_izin_bulan_ini'] = IzinModel::whereMonth('tgl_awal', date('m'))->whereYear('tgl_awal', date('Y'))->get()->count();
        $data['count_cuti_bulan_ini'] = CutiModel::whereMonth('tgl_awal', date('m'))->whereYear('tgl_awal', date('Y'))->get()->count();
        return view("HRD.cuti_izin.index", $data);
    }
    public function all_pengajuan_cuti()
    {
        $now = date('y-m-d');
        $data['allpengajuan_cuti'] = CutiModel::where('tgl_akhir', '>', $now)->get();
        return view("HRD.cuti_izin.listpengajuancuti", $data);
    }
    public function profil_karyawan(Request $request)
    {

        $id_karyawan = $request->id_karyawan;
        //var_dump(KaryawanModel::get_status_karyawan());
        $result = KaryawanModel::find($id_karyawan);
        $nm_sts = $this->get_status_karyawan($result->id_status_karyawan);
       // var_dump(KaryawanModel::get_status_karyawan($result->id_status_karyawan));

        $nm_divisi = ($result->id_divisi==NULL)? "" : $result->get_divisi->nm_divisi;
        $nm_dept = ($result->id_departemen==0)? "" : $result->get_departemen->nm_dept;
        $nm_subdept = ($result->id_subdepartemen==0)? "" : $result->get_subdepartemen->nm_subdept;
        $nm_jabt = ($result->id_jabatan==0)? "" : $result->get_jabatan->nm_jabatan;
        $arr_result = array("nm_status"=>$nm_sts, "nm_divisi"=>$nm_divisi, "nm_dept"=>$nm_dept, "nm_subdept"=>$nm_subdept, "nm_jabt"=>$nm_jabt);
        echo json_encode($arr_result);
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

    public function hitung_jumlah_hari(Request $request)
    {
        $tgl1 = $request->tgl_1;
        $tgl2 = $request->tgl_2;
        $jml_hari = Hrdhelper::selisih_hari($tgl1, $tgl2);
        $tgl_masuk = date('Y-m-d', strtotime($tgl2 . ' +1 day'));
        return response()->json([
            'jumlah_hari' => $jml_hari,
            'tgl_masuk' => $tgl_masuk
        ]);
        // echo $jml_hari+1;
    }
    //cuti Admin
    public function form_cuti()
    {
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        return view('HRD.cuti_izin.cuti.index', ['list_karyawan'=>$res_karyawan, 'list_jenis_cuti'=>$res_jenis_cuti]);
    }
    public function get_sisa_quota_cuti(Request $request)
    {
        $id_karyawan = auth()->user()->karyawan->id;
        $id_jenis_cuti = $request->id_pil_jenis;
        $sisa_quota = $this->ambil_sisa_quota_cuti($id_karyawan, $id_jenis_cuti);
        /*
        $jumlah_quota = JenisCutiIzinModel::find($id_jenis_cuti)->lama_cuti;
        $quota_terpakai = CutiModel::where('id_karyawan', $id_karyawan)->where('id_jenis_cuti', $id_jenis_cuti)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
        $sisa_quota = $jumlah_quota - $quota_terpakai;
        */
        echo $sisa_quota;
    }
    public function rekapitulasi_cuti_tahunan($id_karyawan)
    {
        //$get_ttl = new CutiModel();
        $thn = date("Y");
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        foreach($res_jenis_cuti as $jenis)
        {
            $res_total = CutiModel::where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->where('id_karyawan', $id_karyawan)->where('id_jenis_cuti', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_cuti = 0;
            } else {
                $total_cuti = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_cuti);
        }
        //dd($arr_res);
        return view('HRD.cuti_izin.cuti.rekap_tahunan', ['list_jenis_cuti' => $arr_res, 'id_karyawan'=>$id_karyawan]);
    }
    public function list_cuti_karyawan($id_karyawan)
    {
        $result_list = CutiModel::orderby('id', 'desc')->where('id_karyawan', $id_karyawan)->get();
        return view('HRD.cuti_izin.cuti.list_cuti', ['list_cuti' => $result_list]);
    }
    public function simpan_cuti(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find($request->pil_karyawan)->id_departemen;
        CutiModel::create([
            'sts_pengajuan' => 1,
            'id_karyawan' => $request->pil_karyawan,
            'id_departemen' => $id_depat_karyawan,
            'id_jenis_cuti' => $request->pil_jenis_cuti,
            'tgl_pengajuan' => $request->inp_tgl_pengajuan,
            'tgl_awal' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            // 'tgl_masuk' => $request->tgl_masuk,
            'jumlah_hari' => $request->inp_jumlah_hari,
            'ket_cuti' => $request->keterangan,
            'id_pengganti' => $request->pil_pengganti,
            'id_user' => auth()->user()->id

        ]);
        return redirect('hrd/cutiizin/formcuti')->with('konfirm', 'Data berhasil disimpan');
    }
    //izin
    public function form_izin()
    {
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        $res_jenis_izin = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        return view('HRD.cuti_izin.izin.index', ['list_karyawan'=>$res_karyawan, 'list_jenis_izin'=>$res_jenis_izin]);
    }
    public function list_izin_karyawan($id_karyawan)
    {
        $result_list = IzinModel::orderby('id', 'desc')->where('id_karyawan', $id_karyawan)->get();
        return view('HRD.cuti_izin.izin.list_izin', ['list_izin' => $result_list]);
    }
    public function simpan_izin(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find($request->pil_karyawan)->id_departemen;
        IzinModel::create([
            'sts_pengajuan' => 1, //pencatatan oleh admin, 2.Pengajuan oleh user
            'id_karyawan' => $request->pil_karyawan,
            'id_departemen' => $id_depat_karyawan,
            'id_jenis_izin' => $request->pil_jenis_izin,
            'tgl_pengajuan' => $request->inp_tgl_pengajuan,
            'tgl_awal' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            'jumlah_hari' => $request->inp_jumlah_hari,
            'ket_izin' => $request->keterangan,
            'id_user' => auth()->user()->id //Admin
        ]);
        return redirect('hrd/cutiizin/formizin')->with('konfirm', 'Data berhasil disimpan');
    }
    public function rekapitulasi_izin_tahunan($id_karyawan)
    {
        //$get_ttl = new CutiModel();
        $thn = date("Y");
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        foreach($res_jenis_cuti as $jenis)
        {
            $res_total = IzinModel::where('id_karyawan', $id_karyawan)->where('id_jenis_izin', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_cuti = 0;
            } else {
                $total_cuti = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_cuti);
        }
        //dd($arr_res);
        return view('HRD.cuti_izin.izin.rekap_tahunan', ['list_jenis_izin' => $arr_res, 'id_karyawan'=>$id_karyawan]);
    }


    //approval cuti
    public function daftar_pengajuan_cuti()
    {
        $divisi_user = KaryawanModel::find(auth()->user()->karyawan->id)->id_divisi;
        $lvl_jabatan_user = KaryawanModel::find(auth()->user()->karyawan->id)->get_jabatan->id_level;

        $lvl_appr_user = KaryawanModel::find(auth()->user()->karyawan->id); //cek level jabatan user

        $id_jabatan_setup_hrd = $this->dept_psdm;
        $id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;

        if($id_jabatan_setup_hrd==$id_jabatan_user_hrd) {
            $list_pengajuan = CutiModel::where('sts_pengajuan', 1)
            ->orderby('created_at', 'desc')->get();
        } else {
            $list_pengajuan = CutiModel::where('sts_pengajuan', 1)
                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                    ->orderBy('created_at', 'DESC')->get();
        }
        return view('HRD.cuti_izin.cuti.persetujuan.daftar_pengajuan', ['list_pengajuan' => $list_pengajuan, 'lvl_appr_user' => $lvl_appr_user]);
    }
    public function form_persetujuan_al($id)
    {
        $id_dept_user = auth()->user()->karyawan->id_departemen; //dept atasan langsung
        $res_pengajuan = CutiModel::find($id);
        $sisa_quota = $this->ambil_sisa_quota_cuti($res_pengajuan->id_karyawan, $res_pengajuan->id_jenis_cuti);
        $thn = date("Y");
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        foreach($res_jenis_cuti as $jenis)
        {
            $res_total = CutiModel::where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->where('id_karyawan', $res_pengajuan->id_karyawan)->where('id_jenis_cuti', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_cuti = 0;
            } else {
                $total_cuti = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_cuti);
        }

        $data['profil_pengajuan'] = $res_pengajuan;
        $data['list_karyawan'] = KaryawanModel::whereNotIn('id', [$res_pengajuan->id_karyawan])->whereIn('id_status_karyawan', [1, 2, 3])->where('id_departemen', $id_dept_user)->orderBy('nik')->get();
        $data['sisa_quota'] = $sisa_quota; // + $res_pengajuan->jumlah_hari;
        $data['riwayat_cuti'] = CutiModel::where('id_karyawan', $res_pengajuan->id_karyawan)->where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->orderby('id', 'desc')->get();
        $data['rekap_cuti'] = $arr_res;
        return view("HRD.cuti_izin.cuti.persetujuan.form_persetujuan_al", $data);
    }
    public function simpan_persetujuan_al(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $tgl_persetujuan = date("Y-m-d");
        $update = CutiModel::find($id_pengajuan);
        $update->sts_appr_atasan = $request->pil_persetujuan;
        $update->tgl_appr_atasan = $tgl_persetujuan;
        $update->ket_appr_atasan = $request->keterangan;
        $update->tgl_awal = $request->tgl_mulai;
        $update->tgl_akhir = $request->tgl_akhir;
        $update->jumlah_hari = $request->inp_jumlah_hari;
        $update->id_pengganti = $request->pil_pengganti;
        if($request->pil_persetujuan==2)
        {
            $update->sts_pengajuan = 3; //pengajuan di tolak al
        }
        $update->save();
        return redirect('hrd/cutiizin/daftarpengajuancuti')->with('konfirm', 'Proses persetujuan berhasil disimpan');
    }
    public function form_persetujuan_hrd($id)
    {
        $res_pengajuan = CutiModel::find($id);
        $sisa_quota = $this->ambil_sisa_quota_cuti($res_pengajuan->id_karyawan, $res_pengajuan->id_jenis_cuti);
        $thn = date("Y");
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        foreach($res_jenis_cuti as $jenis)
        {
            $res_total = CutiModel::where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->where('id_karyawan', $res_pengajuan->id_karyawan)->where('id_jenis_cuti', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_cuti = 0;
            } else {
                $total_cuti = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_cuti);
        }

        $data['profil_pengajuan'] = $res_pengajuan;
        $data['sisa_quota'] = $sisa_quota;// + $res_pengajuan->jumlah_hari;
        $data['riwayat_cuti'] = CutiModel::where('id_karyawan', $res_pengajuan->id_karyawan)->where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->orderby('id', 'desc')->get();
        $data['rekap_cuti'] = $arr_res;
        return view("HRD.cuti_izin.cuti.persetujuan.form_persetujuan_hrd", $data);
    }

    public function simpan_persetujuan_hrd(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        if($request->pil_persetujuan==1) { $sts_pengajuan = 2; } else { $sts_pengajuan = 3; }
        $tgl_persetujuan = date("Y-m-d");
        $update = CutiModel::find($id_pengajuan);
        $update->sts_persetujuan = $request->pil_persetujuan;
        $update->tgl_persetujuan = $tgl_persetujuan;
        $update->ket_persetujuan = $request->keterangan;
        $update->sts_pengajuan = $sts_pengajuan;
        $update->save();
        return redirect('hrd/cutiizin/daftarpengajuancuti')->with('konfirm', 'Proses persetujuan berhasil disimpan');
    }
    public function ambil_sisa_quota_cuti($id_karyawan, $id_jenis_cuti)
    {
        $thn = date("Y");
        $jumlah_quota = JenisCutiIzinModel::find($id_jenis_cuti)->lama_cuti;
        //dd($id_karyawan);
        $quota_terpakai = CutiModel::where('id_karyawan', $id_karyawan)->where('id_jenis_cuti', $id_jenis_cuti)->whereYear('tgl_awal', $thn)->where('sts_pengajuan', 2)->sum('jumlah_hari');
        $sisa_quota = $jumlah_quota - $quota_terpakai;
        return $sisa_quota;
    }

    public function ambil_quota_terpakai($id_karyawan, $id_jenis_cuti)
    {
        $thn = date("Y");
        $quota_terpakai = CutiModel::where('id_karyawan', $id_karyawan)->where('id_jenis_cuti', $id_jenis_cuti)->whereYear('tgl_awal', $thn)->where('sts_pengajuan', 2)->sum('jumlah_hari');
        return $quota_terpakai;
    }

    //pengajuan izin
    // public function list_izin()
    // {
    //     $data['result_list'] = IzinModel::where('id_karyawan', auth()->user()->karyawan->id)
    //         ->whereNull('sts_pengajuan')
    //         ->orderby('id', 'desc')->get();
    //     $data['cek_pengajuan'] = IzinModel::where('id_karyawan', auth()->user()->karyawan->id)
    //         ->where('tgl_awal', '>', date('Y-m-d'))->get();
    //     $data['riwayat_izin'] = IzinModel::where('id_karyawan', auth()->user()->karyawan->id)
    //         ->Where('sts_pengajuan', 1)
    //         ->where('tgl_akhir', '<', date("Y-m-d"))
    //         ->where('sts_persetujuan', 1)
    //         ->orderby('id', 'desc')->get();
    //     return view('HRD.cuti_izin.izin.pengajuan.index', $data);
    // }

    // public function form_pengajuan_izin()
    // {
    //     $id_karyawan = auth()->user()->karyawan->id;
    //     $data['list_jenis_izin'] = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
    //     //$data['riwayat_izin'] = IzinModel::where('id_karyawan', $id_karyawan)->orderby('id', 'desc')->get();
    //     return view('HRD.cuti_izin.izin.pengajuan.add', $data);
    // }
    // public function simpan_pengajuan_izin(Request $request)
    // {
    //     IzinModel::create([
    //         'id_karyawan' => auth()->user()->karyawan->id,
    //         'id_jenis_izin' => $request->pil_jenis_izin,
    //         'tgl_pengajuan' => date("Y-m-d"),
    //         'tgl_awal' => $request->tgl_mulai,
    //         'tgl_akhir' => $request->tgl_akhir,
    //         'jumlah_hari' => $request->inp_jumlah_hari,
    //         'ket_izin' => $request->keterangan,
    //         'id_user' => auth()->user()->id
    //     ]);
    //     return redirect('hrd/cutiizin/izin')->with('konfirm', 'Pengajuan anda berhasil disimpan');
    // }

    // public function detai_pengajuan_izin($id)
    // {
    //     $result = IzinModel::find($id);
    //     return view('HRD.cuti_izin.izin.pengajuan.detail', compact('result'));
    // }
//persetujuan
    public function daftar_pengajuan_izin()
    {

        $lvl_appr_user = KaryawanModel::find(auth()->user()->karyawan->id); //cek level jabatan user

        $id_jabatan_setup_hrd = $this->dept_psdm;
        $id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;

        if($id_jabatan_setup_hrd==$id_jabatan_user_hrd) {
            $list_pengajuan = IzinModel::where('sts_pengajuan', 1)
            ->orderby('created_at', 'desc')->get();
        } else {
            $list_pengajuan = IzinModel::where('sts_pengajuan', 1)
                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                    ->orderBy('created_at', 'DESC')->get();
        }
        return view('HRD.cuti_izin.izin.persetujuan.daftar_pengajuan', ['list_pengajuan' => $list_pengajuan, 'lvl_appr_user' => $lvl_appr_user]);
    }

    public function form_persetujuan_izin($id)
    {
        $id_dept_user = auth()->user()->karyawan->id_departemen; //dept atasan langsung
        $thn = date("Y");
        $res_pengajuan = IzinModel::find($id);
        $res_jenis_izin = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        foreach($res_jenis_izin as $jenis)
        {
            $res_total = IzinModel::where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->where('id_karyawan', $res_pengajuan->id_karyawan)->where('id_jenis_izin', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_izin = 0;
            } else {
                $total_izin = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_izin);
        }

        $data['profil_pengajuan'] = $res_pengajuan;
        $data['riwayat_izin'] = IzinModel::where('id_karyawan', $res_pengajuan->id_karyawan)->where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->orderby('id', 'desc')->get();
        $data['rekap_izin'] = $arr_res;
        return view("HRD.cuti_izin.izin.persetujuan.form_persetujuan", $data);
    }
    public function simpan_persetujuan_izin_al(Request $request)
    {
        // if($request->pil_persetujuan==1) { $sts_pengajuan = 1; } else { $sts_pengajuan = 3; }
        $id_pengajuan = $request->id_pengajuan;
        $tgl_persetujuan = date("Y-m-d");
        $update = IzinModel::find($id_pengajuan);
        $update->sts_appr_atasan = $request->pil_persetujuan;
        $update->tgl_appr_atasan = $tgl_persetujuan;
        $update->ket_appr_atasan = $request->keterangan;
        if($request->pil_persetujuan==2) {
             $update->sts_pengajuan = 3; //pengajuan di tolak
        }
        $update->tgl_awal = $request->tgl_mulai;
        $update->tgl_akhir = $request->tgl_akhir;
        $update->jumlah_hari = $request->inp_jumlah_hari;
        // $update->sts_persetujuan = $request->pil_persetujuan; //hasil akhir persetujuan
        $update->save();
        return redirect('hrd/cutiizin/daftarpengajuanizin')->with('konfirm', 'Proses persetujuan berhasil disimpan');
    }

    //hrd - diketahui
    public function form_persetujuan_izin_hrd($id)
    {
        $id_dept_user = auth()->user()->karyawan->id_departemen; //dept atasan langsung
        $thn = date("Y");
        $res_pengajuan = IzinModel::find($id);
        $res_jenis_izin = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        foreach($res_jenis_izin as $jenis)
        {
            $res_total = IzinModel::where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->where('id_karyawan', $res_pengajuan->id_karyawan)->where('id_jenis_izin', $jenis->id)->whereYear('tgl_awal', $thn)->sum('jumlah_hari');
            if(empty($res_total))
            {
                $total_izin = 0;
            } else {
                $total_izin = $res_total;
            }
            $arr_res[] = array('id'=>$jenis->id, 'nama'=>$jenis->nm_jenis_ci, 'total'=>$total_izin);
        }

        $data['profil_pengajuan'] = $res_pengajuan;
        $data['riwayat_izin'] = IzinModel::where('id_karyawan', $res_pengajuan->id_karyawan)->where('sts_appr_atasan', 1)->where('sts_persetujuan', 1)->orderby('id', 'desc')->get();
        $data['rekap_izin'] = $arr_res;
        return view("HRD.cuti_izin.izin.persetujuan.form_persetujuan_hrd", $data);
    }

    public function simpan_persetujuan_izin_hrd(Request $request)
    {
        if($request->pil_persetujuan==1) { $sts_pengajuan = 2; } else { $sts_pengajuan = 3; }
        $id_pengajuan = $request->id_pengajuan;
        $tgl_persetujuan = date("Y-m-d");
        $update = IzinModel::find($id_pengajuan);
        $update->sts_persetujuan = $request->pil_persetujuan;
        $update->tgl_persetujuan = $tgl_persetujuan;
        $update->ket_persetujuan = $request->keterangan;
        $update->sts_pengajuan = $sts_pengajuan; //pengajuan di tolak
        $update->save();
        return redirect('hrd/cutiizin/daftarpengajuanizin')->with('konfirm', 'Proses persetujuan berhasil disimpan');
    }

    //filter data
    public function cui_izin_hari_ini($status)
    {
        $now = date('Y-m-d');
        if($status=='to_day') {
            $data['all_izin_hari_ini'] = IzinModel::where('sts_pengajuan', 2)->where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get();
            $data['all_cuti_hari_ini'] = CutiModel::with([
                'profil_karyawan',
                'profil_karyawan.get_jabatan',
                'profil_karyawan.get_departemen',
                'get_karyawan_pengganti']
                )->where('sts_pengajuan', 2)->where('tgl_awal', '<=', $now)->where('tgl_akhir', '>=', $now)->get()->map( function($newRow){
                $arr = $newRow->toArray();
                $arr['perubahan'] = CutiPerubahanModel::with([
                    'get_cuti_origin',
                    'get_current_approve',
                    'get_current_approve.get_jabatan'
                ])->where('id_head', $arr['id'])->where('sts_pengajuan', 1)->get();
                return $arr;
            });
            return view("HRD.cuti_izin.result_hari_ini", $data);
        } elseif($status=='this_month') {
            $data['all_izin_bulan_ini'] = IzinModel::where('sts_pengajuan', 2)->whereMonth('tgl_awal', date('m'))->whereYear('tgl_awal', date('Y'))->get();
            $data['all_cuti_bulan_ini'] = CutiModel::with([
                'profil_karyawan',
                'profil_karyawan.get_jabatan',
                'profil_karyawan.get_departemen',
                'get_karyawan_pengganti']
                )->where('sts_pengajuan', 2)->whereMonth('tgl_awal', date('m'))->whereYear('tgl_awal', date('Y'))->get()->map( function($newRow){
                $arr = $newRow->toArray();
                $arr['perubahan'] = CutiPerubahanModel::with([
                    'get_cuti_origin',
                    'get_current_approve',
                    'get_current_approve.get_jabatan'
                ])->where('id_head', $arr['id'])->where('sts_pengajuan', 1)->get();
                return $arr;
            });
            return view("HRD.cuti_izin.result_bulan_ini", $data);
        } else {
            $data['pengajuan_cuti'] = CutiModel::where('sts_pengajuan', 1)->get();
            $data['pengajuan_izin'] = IzinModel::where('sts_pengajuan', 1)->get();
            return view("HRD.cuti_izin.result_pengajuan", $data);
        }
    }

    //form pengajuan perubahan
    public function form_perubahan($id)
    {
        $data['profil'] = CutiModel::find($id);
        $data['sisa_quota'] = $this->ambil_sisa_quota_cuti($data['profil']->id_karyawan, $data['profil']->id_jenis_cuti);
        return view("HRD.cuti_izin.form_perubahan", $data);
    }

    public function store_perubahan_cuti(Request $request)
    {
        $karyawan = KaryawanModel::find($request->id_karyawan);
        $id_gakom = JabatanModel::find($karyawan->id_jabatan)->id_gakom;
        $_uuid = Str::uuid();
        $get_approval_first = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        if(!empty($get_approval_first->id))
        {
            CutiPerubahanModel::create([
                'id_head' => $request->id_cuti,
                'tgl_akhir_edit' => $request->tgl_akhir_edit,
                'jumlah_hari_edit' => $request->inp_jumlah_hari_edit,
                'alasan_perubahan' => $request->keterangan,
                'tgl_awal_origin' => $request->tgl_mulai_origin,
                'tgl_akhir_origin' => $request->tgl_akhir_origin,
                'jumlah_hari_origin' => $request->inp_jumlah_hari_origin,
                'create_by' => auth()->user()->id,
                'sts_pengajuan' => 1,
                'approval_key' => $_uuid,
                'current_approval_id' => $get_approval_first->id,
                'is_draft' => 1 //pengajuan masih bisa diedit
            ]);
            $arr_appr =  hrdfunction::set_approval_hrd($id_gakom);
            if(count($arr_appr)>0) {
                foreach($arr_appr as $appr) {
                    $approval_active=0;
                    if($appr['level_approval']==1) {
                        $approval_active = 1;
                    }
                    ApprovalModel::create([
                        'approval_by_employee' => $appr['id_employee'],
                        'approval_level' => $appr['level_approval'],
                        'approval_key' => $_uuid,
                        'approval_group' => 14, //Pengajuan perubahan Cuti
                        'approval_active' => $approval_active
                    ]);
                }
            }
            return redirect('hrd/cutiizin')->with('konfirm', 'Pengajuan perubahan cuti berhasil disimpan');
        } else {
            return redirect('hrd/cutiizin')->with('konfirm', 'Atasan langsung karyawan belum diatur di database. Hubungi Admin HRD');
        }
    }
}
