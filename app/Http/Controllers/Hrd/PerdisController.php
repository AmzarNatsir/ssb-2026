<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\FasilitasPerdisModel;
use App\Models\HRD\UangSakuPerdisModel;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\SetupPersetujuanModel;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\PerdisFasilitasModel;
use Config;
use PDF;
use Illuminate\Support\Str;

class PerdisController extends Controller
{
    private $dept_psdm = 13;

    public function index()
    {
        $data['count_pengajuan'] = PerdisModel::where('sts_pengajuan', 1)->get()->count();
        $data['count_approved'] = PerdisModel::where('sts_pengajuan', 2)->where('tgl_berangkat', '>=', date('Y-m-d'))->get()->count();
        $data['karyawan_perdis'] = PerdisModel::where('sts_pengajuan', 2)->whereMonth('tgl_berangkat', date('m'))->whereYear('tgl_berangkat', date('Y'))->get()->count();
        return view('HRD.perdis.index', $data);
    }

    public function show_data($filter)
    {
        if($filter=="pengajuan")
        {
            $data['list_pengajuan'] = PerdisModel::whereIn('sts_pengajuan', [1])->get();
            return view('HRD.perdis.admin.result_filter', $data);
        }
        if($filter=="proses")
        {
            $data['list_pengajuan'] = PerdisModel::whereIn('sts_pengajuan', [2])->where('tgl_berangkat', '>=', date('Y-m-d'))->get();
            return view('HRD.perdis.admin.result_filter', $data);
        }
        if($filter=="perdis")
        {
            $data['list_pengajuan'] = PerdisModel::where('sts_pengajuan', 2)->whereMonth('tgl_berangkat', date('m'))->whereYear('tgl_berangkat', date('Y'))->get();
            return view('HRD.perdis.admin.result_filter', $data);
        }

    }

    public function list_pengajuan_admin()
    {
        $data['list_pengajuan'] = PerdisModel::whereIn('sts_pengajuan', [1, 2])->where('tgl_berangkat', '>=', date('Y-m-d'))->get();
        return view('HRD.perdis.admin.list_pengajuan', $data);
    }
    //proses pencatatan
    public function form_input()
    {
        //dd($this->buat_nomorsurat_baru());
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        $res_fasilitas = FasilitasPerdisModel::where('status', 1)->get();
        return view('HRD.perdis.baru', ['list_karyawan'=>$res_karyawan, 'list_fasilitas'=>$res_fasilitas]);
    }
    public function profil_karyawan(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        $nom_perdis = $this->buat_nomorsurat_baru();
        $prf = new KaryawanModel();
        $result = $prf->profil($id_karyawan);
        $nm_divisi = $result->nm_divisi;
        $nm_dept = $result->nm_dept;
        $nm_subdept = $result->nm_subdept;
        $nm_jabt = $result->nm_jabatan;
        $arr_result = array("nm_status"=>$this->get_status_karyawan($result->id_status_karyawan), "nm_divisi"=>$nm_divisi, "nm_dept"=>$nm_dept, "nm_subdept"=>$nm_subdept, "nm_jabt"=>$nm_jabt, "nom_perdis"=>$nom_perdis);
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
    public function buat_nomorsurat_baru()
    {
        $thn = date('Y');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SPJ/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = PerdisModel::whereNotNull('no_perdis')->whereYear('tgl_perdis', $thn)->orderBy('id', 'desc')->first();
        if(empty($result->no_perdis))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_perdis, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }
    public function simpan_data(Request $request)
    {
        PerdisModel::create([
            'sts_pengajuan' => 1, //dicatat oleh admin
            'sts_persetujuan' => 2, //dicatat oleh admin
            'id_karyawan' => $request->pil_karyawan,
            'no_perdis' => $request->inp_nomor_surat,
            'tgl_perdis' => $request->inp_tgl_surat,
            'maksud_tujuan' => $request->inp_maksud_tujuan,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_kembali' => $request->tgl_kembali,
            'id_uangsaku' => str_replace(",","", $request->inp_uang_saku),
            'id_fasilitas' => $request->pil_fasilitas,
            'ket_perdis' => $request->keterangan,
            'id_user' => 1 //Admin
        ]);
        return redirect('hrd/perjalanandinas/formperdis')->with('konfirm', 'Data berhasil disimpan');
    }
    public function list_perdis_karyawan($id_karyawan)
    {
        $result_list = PerdisModel::where('sts_persetujuan', 2)->orderby('id', 'desc')->where('id_karyawan', $id_karyawan)->get();
        return view('HRD.perdis.list_perdis', ['list_perdis' => $result_list]);
    }

    public function delete_all()
    {
        \DB::table('hrd_perdis')->truncate();
        return redirect('hrd/karyawan/importTools')->with('konfirm', 'Data berhasil dihapus');
    }

    //Pengajuan
    public function list_pengajuan()
    {
        $data['listpengajuan'] = PerdisModel::where('id_departemen', auth()->user()->karyawan->id_departemen)->orderBy('tgl_perdis', 'Desc')->get();
        return view('HRD.perdis.pengajuan.list_pengajuan', $data);
    }
    public function form_pengajuan()
    {
        // $data['list_karyawan'] = KaryawanModel::where('id_departemen', auth()->user()->karyawan->id_departemen)->get();
        $data['list_karyawan'] = KaryawanModel::select("hrd_karyawan.*")
                ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
                ->where('mst_hrd_jabatan.id_gakom', auth()->user()->karyawan->id_jabatan)->get();

        return view('HRD.perdis.pengajuan.form_pengajuan', $data);
    }
    public function store_pengajuan(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 8;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $arr_tgl = explode(" - ", $request->tgl_berangkat);
            $tgl_1 = explode("/", $arr_tgl[0]);
            $tgl_2 = explode("/", $arr_tgl[1]);
            $tgl_berangkat = $tgl_1[2]."-".$tgl_1[1]."-".$tgl_1[0];
            $tgl_kembali = $tgl_2[2]."-".$tgl_2[1]."-".$tgl_2[0];

            $exec_store = PerdisModel::create([
                'id_karyawan' => $request->pil_karyawan,
                'tujuan' => $request->inp_tujuan,
                'maksud_tujuan' => $request->inp_maksud_tujuan,
                'tgl_berangkat' => $tgl_berangkat,
                'tgl_kembali' => $tgl_kembali,
                'id_departemen' => auth()->user()->karyawan->id_departemen,
                'diajukan_oleh' => auth()->user()->karyawan->id,
                'tgl_pengajuan' => date('Y-m-d'),
                'id_user' => auth()->user()->id,
                'sts_pengajuan' => 1, //pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1 //pengajuan masih bisa diedit
            ]);
            if($exec_store){
                $arr_appr =  hrdfunction::set_approval_new($group, $id_depat_karyawan);
                foreach($arr_appr as $appr)
                {
                    $approval_active=0;
                    if($appr['approval_level']==1) {
                        $approval_active = 1;
                    }
                    ApprovalModel::create([
                        'approval_by_employee' => $appr['approval_by_employee'],
                        'approval_level' => $appr['approval_level'],
                        'approval_key' => $_uuid,
                        'approval_group' => $group, //Pengajuan Cuti
                        'approval_active' => $approval_active
                    ]);
                }
                return redirect('hrd/perjalanandinas/listpengajuan')->with('konfirm', 'Data pengajuan berhasil disimpan');
            } else {
                return redirect('hrd/perjalanandinas/listpengajuan')->with('konfirm', 'Data Gagal disimpan');
            }

        } else {
            return redirect('hrd/perjalanandinas/listpengajuan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    //persetujuan hrd
    public function persetujuan_list_pengajuan()
    {
        $divisi_user = KaryawanModel::find(auth()->user()->karyawan->id)->id_divisi;
        $lvl_jabatan_user = KaryawanModel::find(auth()->user()->karyawan->id)->get_jabatan->id_level;
        $lvl_appr_user = KaryawanModel::find(auth()->user()->karyawan->id); //cek level jabatan user
        $id_jabatan_setup_hrd = $this->dept_psdm;
        $id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;

        if($id_jabatan_setup_hrd==$id_jabatan_user_hrd) {
            $list_pengajuan = PerdisModel::whereIn('sts_pengajuan', [1])->orderBy('tgl_perdis', 'Desc')->get();
        } else {
            if($lvl_jabatan_user==3)
            {
                $list_pengajuan = PerdisModel::select('hrd_perdis.*')
                    ->leftjoin('mst_hrd_departemen', 'hrd_perdis.id_departemen', '=', 'mst_hrd_departemen.id')
                    ->where('hrd_perdis.sts_pengajuan', 1)
                    ->where('mst_hrd_departemen.id_divisi', $divisi_user)
                    ->orderBy('hrd_perdis.tgl_perdis', 'DESC')->get();
            } else {
                $list_pengajuan = PerdisModel::whereIn('sts_pengajuan', [1])->where('id_departemen', auth()->user()->karyawan->id_departemen)->orderBy('tgl_perdis', 'Desc')->get();
            }
        }

        return view('HRD.perdis.persetujuan.list_pengajuan', ['list_pengajuan' => $list_pengajuan, 'lvl_appr_user' => $lvl_appr_user]);
    }
    //persetujuan AL
    public function form_persetujuan_al($id)
    {
        $result = PerdisModel::find($id);
        return view('HRD.perdis.persetujuan.form_persetujuan_al', ['profil' => $result]);
    }

    public function store_persetujuan_al(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $update = PerdisModel::find($id_pengajuan);
        $update->status_approval_al = $request->pil_persetujuan;
        $update->tanggal_approval_al = date("Y-m-d");
        $update->desk_approval_al = $request->inp_keterangan;
        if($request->pil_persetujuan==2)
        {
            $update->sts_pengajuan = 3; //Reject
        }
        $update->save();
        if($update){
            return redirect('hrd/perjalanandinas/persetujuan/listpengajuan')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/perjalanandinas/persetujuan/listpengajuan')->with('konfirm', 'Data Gagal disimpan');
        }
    }
    //persetujuan HRD
    public function form_persetujuan_hrd($id)
    {
        $result = PerdisModel::find($id);
        return view('HRD.perdis.persetujuan.form_persetujuan_hrd', ['profil' => $result]);
    }
    public function store_persetujuan_hrd(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $update = PerdisModel::find($id_pengajuan);
        $update->sts_persetujuan = $request->pil_persetujuan;
        $update->tgl_persetujuan = date("Y-m-d");
        $update->ket_persetujuan = $request->inp_keterangan;
        if($request->pil_persetujuan==1)
        {
            $update->sts_pengajuan = 2; //Approve
        } else {
            $update->sts_pengajuan = 3; //Reject
        }
        $update->save();
        if($update){
            return redirect('hrd/perjalanandinas/persetujuan/listpengajuan')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/perjalanandinas/persetujuan/listpengajuan')->with('konfirm', 'Data Gagal disimpan');
        }
    }

    //admin hrd
    public function form_pengaturan($id)
    {
        $result = PerdisModel::find($id);
        $all_fasilitas = FasilitasPerdisModel::where('status', 1)->get();
        $data = [
            'profil' => $result,
            'list_fasilitas' => $all_fasilitas,
            'jumlah_hari' => hrdfunction::selisih_hari($result->tgl_berangkat, $result->tgl_kembali),
            'fasilitas' => PerdisFasilitasModel::where('id_perdis', $id)->get()
        ];
        return view('HRD.perdis.admin.form_pengaturan', $data);
    }

    public function pengaturan_perdis_store(Request $request)
    {
        $query = PerdisModel::find($request->id_perdis);
        if(empty($query->no_perdis))
        {
            $no_perdis = $this->buat_nomorsurat_baru();
            $query->no_perdis = $this->buat_nomorsurat_baru();
            $query->tgl_perdis = date("Y-m-d");
            $query->save();
        }
        foreach(array($request) as $key => $value)
        {
            for($i=0; $i < count($request->id_fasilitas); $i++)
            {
                if($value['id_data'][$i]==0)
                {
                    PerdisFasilitasModel::create([
                        'id_perdis' => $request->id_perdis,
                        'id_fasilitas' => $value['id_fasilitas'][$i],
                        'hari' => $value['inp_hari'][$i],
                        'biaya' => str_replace(",","", $value['inp_biaya'][$i]),
                        'sub_total' => str_replace(",","", $value['inp_sub_total'][$i])
                    ]);
                } else {
                    $update = PerdisFasilitasModel::find($value['id_data'][$i]);
                    $update->hari = $value['inp_hari'][$i];
                    $update->biaya = str_replace(",","", $value['inp_biaya'][$i]);
                    $update->sub_total = str_replace(",","", $value['inp_sub_total'][$i]);
                    $update->save();
                }
            }
        }
        return redirect('hrd/perjalanandinas')->with('konfirm', 'Pengaturan fasilitas perjalanan dinas berhasil disimpan');
    }

    public function pengaturan_perdis_delete_fasilitas(Request $request)
    {
        $del = PerdisFasilitasModel::find($request->id_data);
        $del->delete();
        echo "Data berhasil dihapus";
    }

    public function detail_perdis($id)
    {
        $data['profil'] = PerdisModel::find($id);
        $data['fasilitas'] = PerdisFasilitasModel::where('id_perdis', $id)->get();
        return view('HRD.perdis.admin.detail_perdis', $data);

    }

    public function print_surat_perdis($id)
    {
        $data['profil'] = PerdisModel::with([
            'get_diajukan_oleh',
            'get_current_approve'
        ])->find($id);
        $data['lastApprover'] = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $data['profil']->approval_key)->orderby('approval_level', 'desc')->first();
        $data['fasilitas'] = PerdisFasilitasModel::where('id_perdis', $id)->get();
        $data['kop_surat'] = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.perdis.admin.print_surat_perdis', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    public function print_rincian_biaya($id)
    {
        $data['profil'] = PerdisModel::with([
            'get_diajukan_oleh',
            'get_current_approve'
        ])->find($id);
        $data['fasilitas'] = PerdisFasilitasModel::where('id_perdis', $id)->get();
        $data['kop_surat'] = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.perdis.admin.print_rincian_biaya', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    //all perdis
    public function list_perdis_admin()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.perdis.admin.list_perdis', $data);
    }

    public function list_perdis_filter_admin($bulan, $tahun, $departemen)
    {
        if($departemen==0) {
            $data['list_data'] = PerdisModel::wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        } else {
            $data['list_data'] = PerdisModel::where('id_departemen', $departemen)->wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        }

        return view('HRD.perdis.admin.list_perdis_result_filter', $data);
    }

    public function list_perdis_detail_admin($id)
    {
        $data['profil'] = PerdisModel::find($id);
        $data['fasilitas'] = PerdisFasilitasModel::where('id_perdis', $id)->get();
        return view('HRD.perdis.admin.list_perdis_result_detail', $data);
    }
}
