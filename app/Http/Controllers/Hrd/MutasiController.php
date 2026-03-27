<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\MutasiModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\DivisiModel;
use App\Models\HRD\SubDepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\SetupPersetujuanModel;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Traits\SubmissionHrd;
use Config;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class MutasiController extends Controller
{

    private $dept_psdm = 13;
    use SubmissionHrd;

    public function index()
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $res_dept = DepartemenModel::where('status', 1)->get();
        $res_monitoring = MutasiModel::whereMonth('tgl_surat', date('m'))->whereYear('tgl_surat', date('Y'))->get();
        $list_pengajuan = MutasiModel::whereNull('no_surat')->get();
        return view('HRD.mutasi.index', ['list_dept'=>$res_dept, 'list_monitoring'=>$res_monitoring, 'list_kategori'=>$res_kategori, 'list_pengajuan' => $list_pengajuan]);
    }
    public function baru()
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $res_divisi = DivisiModel::where('status', 1)->get();
        $res_jabatan = JabatanModel::where('status', 1)->where('id_divisi', 0)->orderby('id_level', 'asc')->get();
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        return view('HRD.mutasi.baru', ['list_karyawan'=>$res_karyawan, 'list_divisi'=>$res_divisi, 'list_jabatan'=>$res_jabatan, 'list_kategori'=>$res_kategori]);
    }
    public function get_profil(Request $request)
    {
        $result = KaryawanModel::find($request->id_karyawan);

        $id_divisi_lama = ($result->id_divisi==0)? "0" : $result->id_divisi;
        $id_dept_lama = ($result->id_departemen==0)? "0" : $result->id_departemen;
        $id_subdept_lama = ($result->id_subdepartemen==0)? "0" : $result->id_subdepartemen;
        $id_jabt_lama = ($result->id_jabatan==0)? "0" : $result->id_jabatan;

        $nm_divisi_lama = ($result->id_divisi==NULL)? "" : $result->get_divisi->nm_divisi;
        $nm_dept_lama = ($result->id_departemen==0)? "" : $result->get_departemen->nm_dept;
        $nm_subdept_lama = ($result->id_subdepartemen==0)? "" : $result->get_subdepartemen->nm_subdept;
        $nm_jabt_lama = ($result->id_jabatan==0)? "" : $result->get_jabatan->nm_jabatan;
        if(empty($result->tmt_jabatan))
        {
            $tgl_eff_jabatan_lm = date("Y-m-d");
        } else {
            $tgl_eff_jabatan_lm = $result->tmt_jabatan;
        }
        //$tgl_eff_jabatan_lm = (empty($result->tmt_jabatan)) ? date("y-m-d") : $result->tmt_jabatan;

        if(empty($result->tgl_masuk)) {
            $ket_lama_kerja = "";
            $tgl_masuk = "Tanpa Keterangan";
        } else {
            $ket_lama_kerja = hrdfunction::get_lama_kerja_karyawan($result->tgl_masuk);
            $tgl_masuk = date_format(date_create($result->tgl_masuk), "d-m-Y");
        }

        $arr_result = array(
            "nm_status_lm"=>$result->get_status_karyawan($result->id_status_karyawan),
            "id_divisi_lm"=>$id_divisi_lama,
            "id_dept_lm"=>$id_dept_lama,
            "id_subdept_lm"=>$id_subdept_lama,
            "id_jabt_lm"=>$id_jabt_lama,
            "nm_divisi_lm"=>$nm_divisi_lama,
            "nm_dept_lm"=>$nm_dept_lama,
            "nm_subdept_lm"=>$nm_subdept_lama,
            "nm_jabt_lm"=>$nm_jabt_lama,
            "tgl_tmt_jabatan_lm" => $tgl_eff_jabatan_lm,
            "no_surat" => $this->buat_nomorsurat_baru(),
            "tgl_masuk" => $tgl_masuk,
            "lama_kerja" =>$ket_lama_kerja);
        echo json_encode($arr_result);
    }
    public function buat_nomorsurat_baru()
    {
        $thn = date('Y');
        // $bln = date('m');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SMK/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = MutasiModel::orderBy('id', 'desc')->first();
        if(empty($result->no_surat))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_surat, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }
    public function get_riwayat_mutasi($id_karyawan)
    {
        $result = MutasiModel::where('id_karyawan', $id_karyawan)->get();
        return view("HRD.mutasi.list_riwayat", ['list_result'=>$result]);
    }
    public function simpan(Request $request)
    {
        MutasiModel::create([
            'id_karyawan' => $request->pil_karyawan,
            'no_auto' => 2, //Manual
            'no_surat' => $request->inp_nomor_surat,
            'tgl_Surat' => $request->inp_tgl_surat,
            'kategori' => $request->pil_kategori,
            'id_divisi_lm' => $request->inp_id_divisi_lama,
            'id_dept_lm' => $request->inp_id_dept_lama,
            'id_subdept_lm' => $request->inp_id_subdept_lama,
            'id_jabt_lm' => $request->inp_id_jabatan_lama,
            'tgl_efektif_lm' => $request->inp_tgl_efektif_lama,
            'id_divisi_br' => $request->pil_divisi_baru,
            'id_dept_br' => $request->pil_dept_baru,
            'id_subdept_br' => $request->pil_subdept_baru,
            'id_jabt_br' => $request->pil_jabt_baru,
            'tgl_efektif_br' => $request->tgl_eff_baru,
            'keterangan' => $request->keterangan,
            'id_user' => 1 //Admin
        ]);
        $update = KaryawanModel::find($request->pil_karyawan);
        $update->id_divisi = $request->pil_divisi_baru;
        $update->id_departemen = $request->pil_dept_baru;
        $update->id_subdepartemen = $request->pil_subdept_baru;
        $update->id_jabatan = $request->pil_jabt_baru;
        $update->tmt_jabatan = $request->tgl_eff_baru;
        $update->save();
        return redirect('hrd/mutasi/baru')->with('konfirm', 'Data berhasil disimpan');
    }
    public function print($id)
    {
        $result = MutasiModel::with(['get_current_approve'])->find($id);
        // $id_kategori = $result->kategori;
        $kop_surat = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.mutasi.print_sk', ['result' => $result, 'kop_surat' => $kop_surat])->setPaper('A4', 'potrait');

        return $pdf->stream();
    }
    public function form_proses($id)
    {
        $result = MutasiModel::find($id);
        $res_kategori = Config::get('constants.kategori_mutasi');
        $no_surat = $this->buat_nomorsurat_baru();
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $result->approval_key)->orderBy('approval_level')->get();
        return view('HRD.mutasi.proses', ['profil' => $result, 'list_kategori' => $res_kategori, 'no_surat' => $no_surat, 'hirarki_persetujuan' => $hirarki_persetujuan]);
    }
    public function store_proses(Request $request)
    {
        $profil_pengajuan = MutasiModel::find($request->id_pengajuan);

        $profil_pengajuan->no_surat = $request->inp_nomor_surat;
        $profil_pengajuan->tgl_surat = $request->inp_tgl_surat;
        $profil_pengajuan->tgl_efektif_br = $request->tgl_eff_baru;
        $profil_pengajuan->no_auto = 2; //auto
        $profil_pengajuan->save();

        $update = KaryawanModel::find($profil_pengajuan->id_karyawan);
        $update->id_divisi = $profil_pengajuan->id_divisi_br;
        $update->id_departemen = $profil_pengajuan->id_dept_br;
        $update->id_subdepartemen = $profil_pengajuan->id_subdept_br;
        $update->id_jabatan = $profil_pengajuan->id_jabt_br;
        $update->tmt_jabatan = $profil_pengajuan->tgl_eff_baru;
        $update->evaluasi_kerja = NULL;
        $update->kategori_evaluasi_kerja = NULL;
        $update->save();
        return redirect('hrd/mutasi')->with('konfirm', 'Data berhasil disimpan');
    }

    //pengajuan
    public function list_pengajuan()
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $list_pengajuan = MutasiModel::whereIn('status_pengajuan', [1, 2])->where('id_departemen', auth()->user()->karyawan->id_departemen)->get();
        return view('HRD.mutasi.pengajuan.index', ['list_pengajuan' => $list_pengajuan, 'list_kategori'=>$res_kategori]);
    }
    public function form_pengajuan()
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $res_divisi = DivisiModel::where('status', 1)->get();
        $res_jabatan = JabatanModel::where('status', 1)->where('id_divisi', 0)->orderby('id_level', 'asc')->get();
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])
                ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                ->whereNotIn('id', [auth()->user()->karyawan->id])->get();
        return view('HRD.mutasi.pengajuan.add', ['list_karyawan'=>$res_karyawan, 'list_divisi'=>$res_divisi, 'list_jabatan'=>$res_jabatan, 'list_kategori'=>$res_kategori]);
    }
    public function store_pengajuan(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 6;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $filename = NULL;
            if($request->hasFile('inp_file_evaluasi'))
            {
                $path = storage_path("app/public/hrd/hasil_evaluasi_karyawan");
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('hrd/hasil_evaluasi_karyawan');
                }
                $file = $request->file('inp_file_evaluasi');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/hrd/hasil_evaluasi_karyawan', $filename);
            }

            $exec_store =MutasiModel::create([
                'id_karyawan' => $request->pil_karyawan,
                'kategori' => $request->pil_kategori,
                'id_divisi_lm' => $request->inp_id_divisi_lama,
                'id_dept_lm' => $request->inp_id_dept_lama,
                'id_subdept_lm' => $request->inp_id_subdept_lama,
                'id_jabt_lm' => $request->inp_id_jabatan_lama,
                'tgl_efektif_lm' => $request->inp_tgl_efektif_lama,
                'id_divisi_br' => $request->pil_divisi_baru,
                'id_dept_br' => $request->pil_dept_baru,
                'id_subdept_br' => $request->pil_subdept_baru,
                'id_jabt_br' => $request->pil_jabt_baru,
                'keterangan' => $request->keterangan,
                'id_user' => auth()->user()->id,
                'tgl_pengajuan' => date("Y-m-d"),
                'id_departemen' => auth()->user()->karyawan->id_departemen,
                'diajukan_oleh' => auth()->user()->karyawan->id,
                'alasan_pengajuan' => $request->keterangan,
                'status_pengajuan' => 1, //Pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1, //pengajuan masih bisa diedit
                'file_hasil_evaluasi' => $filename
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
                //update status pengajuan di table karyawan
                SubmissionHrd::update_current_mutasi($request->pil_karyawan);
                return redirect('hrd/mutasi/listpengajuan')->with([
                    'konfirm' => 'Data berhasil disimpan',
                    'status' => true
                    ]);
            } else {
                return redirect('hrd/mutasi/listpengajuan')->with([
                    'konfirm', 'Data Gagal disimpan',
                    'status' => false
                ]);
            }

        } else {
            return redirect('hrd/mutasi/listpengajuan')->with([
                'konfirm' => 'Matriks persetujuan belum diatur',
                'status' => false
            ]);
        }
    }

    //Persetujuan
    public function list_persetujuan()
    {
        $res_kategori = Config::get('constants.kategori_mutasi');

        $divisi_user = KaryawanModel::find(auth()->user()->karyawan->id)->id_divisi;
        $lvl_jabatan_user = KaryawanModel::find(auth()->user()->karyawan->id)->get_jabatan->id_level;

        $lvl_appr_user = KaryawanModel::find(auth()->user()->karyawan->id); //cek level jabatan user

        $id_jabatan_setup_hrd = $this->dept_psdm;
        $id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;

        if($id_jabatan_setup_hrd==$id_jabatan_user_hrd) {
            $list_pengajuan = MutasiModel::whereIn('status_pengajuan', [1])->get();
        } else {
            if($lvl_jabatan_user==3)
            {
                $list_pengajuan = MutasiModel::select('hrd_mutasi.*')
                    ->leftjoin('mst_hrd_departemen', 'hrd_mutasi.id_departemen', '=', 'mst_hrd_departemen.id')
                    ->where('hrd_mutasi.status_pengajuan', 1)
                    ->where('mst_hrd_departemen.id_divisi', $divisi_user)
                    ->orderBy('hrd_mutasi.created_at', 'DESC')->get();
            } else {
                $list_pengajuan = MutasiModel::whereIn('status_pengajuan', [1])->where('id_departemen', auth()->user()->karyawan->id_departemen)->get();
            }
        }

        return view('HRD.mutasi.persetujuan.index', ['list_pengajuan' => $list_pengajuan, 'list_kategori'=>$res_kategori, 'lvl_appr_user' => $lvl_appr_user]);
    }

    public function form_pengajuan_edit($id)
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $res_divisi = DivisiModel::where('status', 1)->get();
        $result = MutasiModel::with(['get_profil'])->find($id);

        if(empty($result->get_profil->tgl_masuk)) {
            $ket_lama_kerja = "";
            $tgl_masuk = "Tanpa Keterangan";
        } else {
            $ket_lama_kerja = hrdfunction::get_lama_kerja_karyawan($result->get_profil->tgl_masuk);
            $tgl_masuk = date_format(date_create($result->get_profil->tgl_masuk), "d-m-Y");
        }

        $list_departemen = DepartemenModel::where('id_divisi', $result->id_divisi_br)->get();
        $list_sub_departemen = SubDepartemenModel::where('id_dept', $result->id_dept_br)->get();
        if($result->id_dept_br==0 || empty($result->id_dept_br)) {
            $list_jabatan = JabatanModel::where('status', 1)->where('id_dept', $result->id_dept_br)->orderby('id_level', 'asc')->get();
        } else {
            $list_jabatan = JabatanModel::where('status', 1)->where('id_dept', $result->id_dept_br)->where('id_subdept', $result->id_subdept_br)->orderby('id_level', 'asc')->get();
        }


        return view('HRD.mutasi.pengajuan.edit', [
            'karyawan'=>$result,
            'list_divisi'=>$res_divisi,
            'list_departemen' => $list_departemen,
            'list_sub_departemen' => $list_sub_departemen,
            'list_jabatan'=>$list_jabatan,
            'list_kategori'=>$res_kategori,
            "nm_status_lm"=> $result->get_profil->get_status_karyawan($result->get_profil->id_status_karyawan),
            "tgl_masuk" => $tgl_masuk,
            "lama_kerja" => $ket_lama_kerja
        ]);
    }

    public function form_pengajuan_update(Request $request, $id)
    {
        $exec_store = MutasiModel::find($id)->update([
            'kategori' => $request->pil_kategori,
            'id_divisi_br' => $request->pil_divisi_baru,
            'id_dept_br' => $request->pil_dept_baru,
            'id_subdept_br' => $request->pil_subdept_baru,
            'id_jabt_br' => $request->pil_jabt_baru,
            'keterangan' => $request->keterangan
        ]);
        if($exec_store){
            return redirect('hrd/mutasi/listpengajuan')->with([
                'konfirm' => 'Perubahan data berhasil disimpan',
                'status' => true
                ]);
        } else {
            return redirect('hrd/mutasi/listpengajuan')->with([
                'konfirm', 'Perubahan data gagal disimpan',
                'status' => false
            ]);
        }
    }

    public function form_pengajuan_detail($id)
    {
        $res_kategori = Config::get('constants.kategori_mutasi');
        $res_divisi = DivisiModel::where('status', 1)->get();
        $result = MutasiModel::with(['get_profil'])->find($id);

        if(empty($result->get_profil->tgl_masuk)) {
            $ket_lama_kerja = "";
            $tgl_masuk = "Tanpa Keterangan";
        } else {
            $ket_lama_kerja = hrdfunction::get_lama_kerja_karyawan($result->get_profil->tgl_masuk);
            $tgl_masuk = date_format(date_create($result->get_profil->tgl_masuk), "d-m-Y");
        }

        $list_departemen = DepartemenModel::where('id_divisi', $result->id_divisi_br)->get();
        $list_sub_departemen = SubDepartemenModel::where('id_dept', $result->id_dept_br)->get();
        if($result->id_dept_br==0 || empty($result->id_dept_br)) {
            $list_jabatan = JabatanModel::where('status', 1)->where('id_dept', $result->id_dept_br)->orderby('id_level', 'asc')->get();
        } else {
            $list_jabatan = JabatanModel::where('status', 1)->where('id_dept', $result->id_dept_br)->where('id_subdept', $result->id_subdept_br)->orderby('id_level', 'asc')->get();
        }


        return view('HRD.mutasi.pengajuan.detail', [
            'karyawan'=>$result,
            'list_divisi'=>$res_divisi,
            'list_departemen' => $list_departemen,
            'list_sub_departemen' => $list_sub_departemen,
            'list_jabatan'=>$list_jabatan,
            'list_kategori'=>$res_kategori,
            "nm_status_lm"=> $result->get_profil->get_status_karyawan($result->get_profil->id_status_karyawan),
            "tgl_masuk" => $tgl_masuk,
            "lama_kerja" => $ket_lama_kerja
        ]);
    }

    public function form_pengajuan_delete(Request $request, $id)
    {
        $execDelete = MutasiModel::find($id);
        $appr_key = $execDelete->approval_key;
        $execDelete->delete();

        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $appr_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $appr_key)->delete();
        }
        if($execDelete){
            return redirect('hrd/mutasi/listpengajuan')->with([
                'konfirm' => 'Perubahan data berhasil disimpan',
                'status' => true
                ]);
        } else {
            return redirect('hrd/mutasi/listpengajuan')->with([
                'konfirm', 'Perubahan data gagal disimpan',
                'status' => false
            ]);
        }
    }

    public function mutasi_showPdf($id)
    {
        $pdf_file = MutasiModel::find($id);
        $filePath = storage_path("app/public/hrd/hasil_evaluasi_karyawan/".$pdf_file->file_hasil_evaluasi);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    //Atasan Langsung
    public function form_persetujuan_al($id)
    {
        $result = MutasiModel::find($id);
        $res_kategori = Config::get('constants.kategori_mutasi');
        if(empty($result->get_profil->tgl_masuk)) {
            $ket_lama_kerja = "";
            $tgl_masuk = "Tanpa Keterangan";
        } else {
            $ket_lama_kerja = hrdfunction::get_lama_kerja_karyawan($result->get_profil->tgl_masuk);
            $tgl_masuk = date_format(date_create($result->get_profil->tgl_masuk), "d-m-Y");
        }
        if(empty($result->get_profil->tmt_jabatan))
        {
            $tgl_eff_jabatan = date("Y-m-d");
        } else {
            $tgl_eff_jabatan = date("d-m-Y", strtotime($result->get_profil->tmt_jabatan));
        }
        return view('HRD.mutasi.persetujuan.add_al', [
            'profil' => $result,
            'list_kategori' => $res_kategori,
            'ket_lama_kerja' => $ket_lama_kerja,
            'ket_tgl_masuk' =>$tgl_masuk,
            'ket_efektif_jabatan' =>  $tgl_eff_jabatan
        ]);
    }
    public function store_persetujuan_al(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $update = MutasiModel::find($id_pengajuan);
        $update->status_approval_al = $request->pil_persetujuan;
        $update->tanggal_approval_al = date("Y-m-d");
        $update->desk_approval_al = $request->inp_keterangan;
        if($request->pil_persetujuan==2) //jika reject
        {
            $update->status_pengajuan = 3; //reject
        }
        $update->save();
        if($update){
            return redirect('hrd/mutasi/listpersetujuan')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/mutasi/listpersetujuan')->with('konfirm', 'Data Gagal disimpan');
        }
    }
    //HRD
    public function form_persetujuan($id)
    {
        $result = MutasiModel::find($id);
        $res_kategori = Config::get('constants.kategori_mutasi');
        if(empty($result->get_profil->tgl_masuk)) {
            $ket_lama_kerja = "";
            $tgl_masuk = "Tanpa Keterangan";
        } else {
            $ket_lama_kerja = hrdfunction::get_lama_kerja_karyawan($result->get_profil->tgl_masuk);
            $tgl_masuk = date_format(date_create($result->get_profil->tgl_masuk), "d-m-Y");
        }
        if(empty($result->get_profil->tmt_jabatan))
        {
            $tgl_eff_jabatan = date("Y-m-d");
        } else {
            $tgl_eff_jabatan = date("d-m-Y", strtotime($result->get_profil->tmt_jabatan));
        }
        return view('HRD.mutasi.persetujuan.add', [
            'profil' => $result,
            'list_kategori' => $res_kategori,
            'ket_lama_kerja' => $ket_lama_kerja,
            'ket_tgl_masuk' =>$tgl_masuk,
            'ket_efektif_jabatan' =>  $tgl_eff_jabatan
        ]);
    }

    public function store_persetujuan(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $update = MutasiModel::find($id_pengajuan);
        $update->sts_persetujuan = $request->pil_persetujuan;
        $update->tgl_persetujuan = date("Y-m-d");
        $update->ket_persetujuan = $request->inp_keterangan;
        if($request->pil_persetujuan==1) //jika approve
        {
            $update->status_pengajuan = 2; //approved
        } else {
            $update->status_pengajuan = 3; //reject
        }
        $update->save();
        if($update){
            return redirect('hrd/mutasi/listpersetujuan')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/mutasi/listpersetujuan')->with('konfirm', 'Data Gagal disimpan');
        }
    }

    //add
    public function load_jabatan_default()
    {
        $res_jabatan = JabatanModel::where('status', 1)
                ->where('id_divisi', 0)
                ->orWhere('id_divisi', '=', '')
                ->orWhereNull('id_divisi')->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_jabatan_divisi($di_divisi)
    {
        $res_jabatan = JabatanModel::where('status', 1)
                        ->where('id_divisi', $di_divisi)
                        ->where('id_dept', NULL)
                        ->where(function($q){
                            $q->where('id_subdept', 0)->orwhereNull('id_subdept');
                        })->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_jabatan_dept($id_dept)
    {
        $res_jabatan = JabatanModel::where('status', 1)->where('id_dept', $id_dept)->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }

    public function load_jabatan_subdept($id_subdept)
    {
        $res_jabatan = JabatanModel::where('status', 1)->where('id_subdept', $id_subdept)->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_departement($id_divisi)
    {
        $res_departemen = DepartemenModel::where('status', 1)->where('id_divisi', $id_divisi)->get();
        echo "<option value='0'>Non Departemen</option>";
        foreach($res_departemen as $list_dept){
            echo "<option value=".$list_dept->id.">".$list_dept->nm_dept."</option>";
        }
    }
    public function load_subdept($id_dept)
    {
        $result_subdept = SubDepartemenModel::where('id_dept', $id_dept)->get();
        echo "<option value='0'>Non Sub Departemen</option>";
        foreach($result_subdept as $subdept)
        {
            echo "<option value=".$subdept->id.">".$subdept->nm_subdept."</option>";
        }
    }

}
