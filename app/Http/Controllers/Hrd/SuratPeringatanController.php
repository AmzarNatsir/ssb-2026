<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\JenisPelanggaranModel;
use Illuminate\Http\Request;
use App\Models\HRD\SuratPeringatanModel;
use App\Models\HRD\JenisSPModel;
use App\Models\HRD\KaryawanModel;
use Config;
use PDF;
use Illuminate\Support\Str;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\SPNonAktifModel;
use App\Models\HRD\SuratTeguranModel;

class SuratPeringatanController extends Controller
{
    public function index()
    {
        $data['list_sp'] = SuratPeringatanModel::with(['profil_karyawan', 'get_master_jenis_sp_diajukan', 'get_diajukan_oleh'])->orderby('tgl_pengajuan', 'desc')->get();
        $data['list_st'] = SuratTeguranModel::orderBy('tanggal_pengajuan', 'desc')->get();
        $data['count_pengajuan_sp'] = SuratPeringatanModel::where('sts_pengajuan', 1)->get()->count();
        $data['count_pengajuan_st'] = SuratTeguranModel::where('status_pengajuan', 1)->get()->count();
        $data['count_sp_aktif'] = KaryawanModel::where('sp_active', 'active')->get()->count();
        $data['count_st_aktif'] = SuratTeguranModel::where('status_pengajuan', 2)->get()->count();
        $data['count_sp_non_aktif'] = SPNonAktifModel::where('sts_pengajuan', 1)->get()->count();
        return view('HRD.surat_peringatan.index', $data);
    }
    public function show_data($filter) {
        if($filter=="pengajuan_st")
        {
            $data['list_pengajuan'] = SuratTeguranModel::where('status_pengajuan', 1)->get();
            // $data['ket'] = "Daftar Pengajuan Lembur";
            return view('HRD.surat_peringatan.result_filter_st', $data);
        }
        if($filter=="pengajuan_sp")
        {
            $data['list_pengajuan'] = SuratPeringatanModel::where('sts_pengajuan', 1)->get();
            return view('HRD.surat_peringatan.result_filter_sp', $data);
        }
        if($filter=="sp_aktif")
        {
            $data['list_sp'] = KaryawanModel::with([
                'get_jenis_sp',
                'get_detail_sp',
                'get_detail_sp.get_penonaktifan_sp'
            ])->where('sp_active', 'active')->get();
            return view('HRD.surat_peringatan.result_filter_sp_aktif', $data);
        }
        if($filter=="st_aktif")
        {
            $data['list_st'] = SuratTeguranModel::with([
                'get_karyawan',
                'get_jenis_pelanggaran'
            ])->where('status_pengajuan', 2)->get();
            return view('HRD.surat_peringatan.result_filter_st_aktif', $data);
        }
        if($filter=="sp_non_aktif")
        {
            $data['list_pengajuan'] = SPNonAktifModel::with([
                'getSP',
                'getSP.profil_karyawan'
            ])->where('sts_pengajuan', 1)->get();
            // dd($data);
            return view('HRD.surat_peringatan.result_filter_sp_non_aktif', $data);
        }
    }
    public function form_input()
    {
        $res_karyawan = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        $res_jenis_sp = JenisSPModel::where('status', 1)->get();
        return view('HRD.surat_peringatan.baru', ['list_karyawan'=>$res_karyawan, 'list_jenis_sp'=>$res_jenis_sp]);
    }
    public function list_sp_karyawan($id_karyawan)
    {
        $result = SuratPeringatanModel::where('id_karyawan', $id_karyawan)->get();
        return view("HRD.surat_peringatan.list_riwayat", ['list_result'=>$result]);
    }
    public function simpan_data(Request $request)
    {
        SuratPeringatanModel::create([
            'sts_pengajuan' => 1, //dicatat oleh admin
            'id_karyawan' => $request->pil_karyawan,
            'no_sp' => $request->inp_nomor_surat,
            'tgl_sp' => $request->inp_tgl_surat,
            'uraian_pelanggaran' => $request->inp_uraian_pelanggaran,
            'id_jenis_sp_disetujui' => $request->pil_jenis_sp,
            'id_user' => auth()->user()->id
        ]);
        return redirect('hrd/suratperingatan/formsp')->with('konfirm', 'Data berhasil disimpan');
    }
    public function print_sp($id)
    {
        $dt_sp = SuratPeringatanModel::find($id);
        //$data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $approval = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $dt_sp->approval_key)->orderBy('approval_level')->get();
        $countColumn = count($approval);
        $witdhColumn =  100 / ($countColumn+1);
        $data = [
            'dt_sp' => $dt_sp,
            'approval' => $approval,
            'witdhColumn' => $witdhColumn,
            'kop_surat' => hrdfunction::get_kop_surat()
        ];
        $pdf = PDF::loadview('HRD.surat_peringatan.print_sp', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    //Pengajuan user
    public function list_pengajuan()
    {
        $data['count_pengajuan_sp'] = SuratPeringatanModel::where('sts_pengajuan', 1)->where('create_by', auth()->user()->karyawan->id)->get()->count();
        $data['count_pengajuan_st'] = SuratTeguranModel::where('status_pengajuan', 1)->where('create_by', auth()->user()->karyawan->id)->get()->count();
        $data['count_sp_aktif'] = KaryawanModel::where('sp_active', 'active')->where('id_departemen', auth()->user()->karyawan->id_departemen)->get()->count();
        $data['count_st_aktif'] = SuratTeguranModel::where('status_pengajuan', 2)->where('create_by', auth()->user()->karyawan->id)->get()->count();
        return view('HRD.surat_peringatan.pengajuan.daftar_pengajuan', $data);
    }
    public function show_pengajuan_data($filter) {
        if($filter=="pengajuan_st")
        {
            $data['list_pengajuan'] = SuratTeguranModel::where('status_pengajuan', 1)->where('create_by', auth()->user()->karyawan->id)->get();
            // $data['ket'] = "Daftar Pengajuan Lembur";
            return view('HRD.surat_peringatan.pengajuan.result_filter_pengajuan_st', $data);
        }
        if($filter=="pengajuan_sp")
        {
            $data['list_pengajuan'] = SuratPeringatanModel::where('sts_pengajuan', 1)->where('create_by', auth()->user()->karyawan->id)->get();
            return view('HRD.surat_peringatan.pengajuan.result_filter_pengajuan_sp', $data);
        }
        if($filter=="sp_aktif")
        {
            $data['list_sp'] = KaryawanModel::with([
                'get_jenis_sp',
                'get_detail_sp'
            ])->where('sp_active', 'active')->where('id_departemen', auth()->user()->karyawan->id_departemen)->get();
            return view('HRD.surat_peringatan.pengajuan.result_filter_pengajuan_sp_aktif', $data);
        }
        if($filter=="st_aktif")
        {
            $data['list_st'] = SuratTeguranModel::with([
                'get_karyawan',
                'get_jenis_pelanggaran'
            ])->where('status_pengajuan', 2)->where('create_by', auth()->user()->karyawan->id)->get();
            return view('HRD.surat_peringatan.pengajuan.result_filter_pengajuan_st_aktif', $data);
        }
    }
    //pengajuan surat teguran
    public function form_pengajuan_st()
    {
        $all_karyawan = KaryawanModel::select("hrd_karyawan.*")
        ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
        ->whereIn('hrd_karyawan.id_status_karyawan', [1, 2, 3])
        ->where('mst_hrd_jabatan.id_gakom', auth()->user()->karyawan->id_jabatan)->get();
        $jenis_pelanggaran = JenisPelanggaranModel::all();
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan_st', [
            'list_karyawan'=>$all_karyawan,
            'list_jenis_pelanggaran' => $jenis_pelanggaran
        ]);
    }
    public function store_pengajuan_st(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 10;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $exec_store = SuratTeguranModel::create([
                'id_karyawan' => $request->pil_karyawan,
                'tanggal_kejadian' => $request->inp_tanggal,
                'waktu_kejadian' => $request->inp_waktu,
                'tempat_kejadian' => $request->inp_tempat,
                'id_jenis_pelanggaran' => $request->pil_jenis_pelanggaran,
                'akibat' => $request->inp_akibat,
                'tindakan' => $request->inp_tindakan,
                'rekomendasi' => $request->inp_rekomendasi,
                'komentar_pelanggar' => $request->inp_komentar_pelanggar,
                'tanggal_pengajuan' => date('Y-m-d'),
                'create_by' => auth()->user()->karyawan->id,
                'status_pengajuan' => 1, //pengajuan
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
                return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Data pengajuan berhasil disimpan');
            } else {
                return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Data Gagal disimpan');
            }
        } else {
            return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }
    public function form_edit_pengajuan_st($id)
    {
        $all_karyawan = KaryawanModel::select("hrd_karyawan.*")
        ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
        ->whereIn('hrd_karyawan.id_status_karyawan', [1, 2, 3])
        ->where('mst_hrd_jabatan.id_gakom', auth()->user()->karyawan->id_jabatan)->get();
        $jenis_pelanggaran = JenisPelanggaranModel::all();
        $profil = SuratTeguranModel::find($id);
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan_st_edit', [
            'list_karyawan'=>$all_karyawan,
            'list_jenis_pelanggaran' => $jenis_pelanggaran,
            'profil' => $profil
        ]);
    }
    public function update_pengajuan_st(Request $request, $id)
    {
        $update = SuratTeguranModel::find($id);
        $update->id_karyawan = $request->pil_karyawan;
        $update->tanggal_kejadian = $request->inp_tanggal;
        $update->waktu_kejadian = $request->inp_waktu;
        $update->tempat_kejadian = $request->inp_tempat;
        $update->id_jenis_pelanggaran = $request->pil_jenis_pelanggaran;
        $update->akibat = $request->inp_akibat;
        $update->tindakan = $request->inp_tindakan;
        $update->rekomendasi = $request->inp_rekomendasi;
        $update->komentar_pelanggar = $request->inp_komentar_pelanggar;
        $update->save();
        return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Perubahan pengajuan berhasil disimpan');
    }
    public function form_detail_pengajuan_st($id)
    {
        $profil = SuratTeguranModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan_st_detail', [
            'profil' => $profil,
            'hirarki_persetujuan' => $hirarki_persetujuan
        ]);
    }
    public function cancel_pengajuan_st($id)
    {
        $data = SuratTeguranModel::find($id);
        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $data->approval_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $data->approval_key)->delete();
        }
        $data->delete();
        return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Pengajuan berhasil dibatalkan');
    }
    public function print_st($id)
    {
        $data['dt_st'] = SuratTeguranModel::find($id);
        // $data['hirarki_persetujuan'] = ApprovalModel::where('approval_key', $data['dt_st']->approval_key)->orderBy('approval_level')->get();
        //$data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['kop_surat'] = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.surat_peringatan.print_st_baru', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    //sp
    public function form_pengajuan()
    {
        $id_user = auth()->user()->karyawan->id;
        $id_dept_user = auth()->user()->karyawan->id_departemen;
        $res_karyawan = KaryawanModel::where('id_departemen', $id_dept_user)->whereIn('id_status_karyawan', [1, 2, 3])->whereNotIn('id', [$id_user])->get();
        $res_jenis_sp = JenisSPModel::where('status', 1)->get();
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan', ['list_karyawan'=>$res_karyawan, 'list_jenis_sp'=>$res_jenis_sp]);
    }
    public function store_pengajuan_sp(Request $request)
    {
        $id_dept_karyawan = KaryawanModel::find($request->pil_karyawan)->id_departemen;
        $_uuid = Str::uuid();
        $group = 11;
        $ifSet = hrdfunction::set_approval_cek($group, $id_dept_karyawan);
        if($ifSet > 0)
        {
            $exec_store = SuratPeringatanModel::create([
                'id_karyawan' => $request->pil_karyawan,
                'tgl_pengajuan' => date('Y-m-d'),
                'uraian_pelanggaran' => $request->inp_uraian_pelanggaran,
                'id_jenis_sp_disetujui' => $request->pil_jenis_sp,
                'id_jenis_sp_pengajuan' => $request->pil_jenis_sp,
                'id_user' => auth()->user()->id,
                'id_departemen' => $id_dept_karyawan,
                'sts_pengajuan' => 1, //pengajuan
                'create_by' => auth()->user()->karyawan->id,
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_dept_karyawan),
                'is_draft' => 1 //pengajuan masih bisa diedit
            ]);
            if($exec_store){
                $arr_appr =  hrdfunction::set_approval_new($group, $id_dept_karyawan);
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
                return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Data pengajuan berhasil disimpan');
            } else {
                return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Data Gagal disimpan');
            }
        } else {
            return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }
    public function form_edit_pengajuan_sp($id)
    {
        $all_karyawan = KaryawanModel::select("hrd_karyawan.*")
        ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
        ->whereIn('hrd_karyawan.id_status_karyawan', [1, 2, 3])
        ->where('mst_hrd_jabatan.id_gakom', auth()->user()->karyawan->id_jabatan)->get();
        $res_jenis_sp = JenisSPModel::where('status', 1)->get();
        $profil = SuratPeringatanModel::find($id);
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan_sp_edit', [
            'list_karyawan'=> $all_karyawan,
            'res_jenis_sp' => $res_jenis_sp,
            'profil' => $profil
        ]);
    }
    public function update_pengajuan_sp(Request $request, $id)
    {
        $update = SuratPeringatanModel::find($id);
        $update->id_karyawan = $request->pil_karyawan;
        $update->id_jenis_sp_pengajuan = $request->pil_jenis_sp;
        $update->uraian_pelanggaran = $request->inp_uraian_pelanggaran;
        $update->save();
        return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Perubahan pengajuan berhasil disimpan');
    }
    public function form_detail_pengajuan_sp($id)
    {
        $profil = SuratPeringatanModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        return view('HRD.surat_peringatan.pengajuan.form_pengajuan_sp_detail', [
            'profil' => $profil,
            'hirarki_persetujuan' => $hirarki_persetujuan
        ]);
    }
    public function cancel_pengajuan_sp($id)
    {
        $data = SuratPeringatanModel::find($id);
        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $data->approval_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $data->approval_key)->delete();
        }
        $data->delete();
        return redirect('hrd/suratperingatan/listPengajuan')->with('konfirm', 'Pengajuan berhasil dibatalkan');
    }

    static function buat_nomorsurat_baru()
    {
        $thn = date('Y');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SSB/SP";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = SuratPeringatanModel::whereNotNull('no_sp')->orderBy('tgl_sp', 'desc')->first();
        if(empty($result->no_surat))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_sp, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }
    public function form_detail_sp($id)
    {
        $profil = SuratPeringatanModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        return view('HRD.surat_peringatan.form_sp_detail', [
            'profil' => $profil,
            'hirarki_persetujuan' => $hirarki_persetujuan
        ]);
    }

    //non aktif SP
    public function form_non_aktif_sp($id)
    {
        $main = SuratPeringatanModel::find($id);
        $data = [
            'profil' => $main,
            'hirarki_persetujuan' => ApprovalModel::where('approval_key', $main->approval_key)->orderBy('approval_level')->get()
        ];
        return view('HRD.surat_peringatan.non_aktif.form_non_aktif', $data);
    }

    public function store_non_aktif_sp(Request $request)
    {
        // $id_gakom = JabatanModel::find($request->id_karyawan_jabatan)->id_gakom;
        // $_uuid = Str::uuid();
        // $get_approval_first = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        $id_depat_karyawan = SuratPeringatanModel::find($request->id_sp)->id_departemen;
        $_uuid = Str::uuid();
        $group = 17;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $exec_store = SPNonAktifModel::create([
                'id_sp' => $request->id_sp,
                'alasan_non_aktif' => $request->inp_alasan,
                'sts_pengajuan' => 1, //Pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'create_by' => auth()->user()->id,
                'is_draft' => 1,
                'created_at' => date("Y-m-d H:i:s")
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
                return redirect('hrd/suratperingatan')->with('konfirm', 'Data pengajuan berhasil disimpan');
            } else {
                return redirect('hrd/suratperingatan')->with('konfirm', 'Data Gagal disimpan');
            }
        } else {
            return redirect('hrd/suratperingatan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

}
