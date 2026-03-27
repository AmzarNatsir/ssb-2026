<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\PerubahanStatusModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\SetupPersetujuanModel;
use Config;
use PDF;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\JabatanModel;
use App\Traits\SubmissionHrd;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class PerubahanStatusController extends Controller
{

   use SubmissionHrd;

    public function index()
    {
        $toDay = date("Y-m-d");
        $day30 = date('Y-m-d', strtotime($toDay . ' +30 day'));
        // $data['list_bulan'] = Config::get("constants.bulan");
        // $data['list_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_jtp_hari_ini'] = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)->whereIn('id_status_karyawan', [1, 2])->get();
        $data['list_pengajuan'] = PerubahanStatusModel::whereIn('status_pengajuan', [1, 2])
                                ->whereNull('no_surat')->get();
        $data['dueDay'] = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)->whereIn('id_status_karyawan', [1, 2])->get()->count();
        $data['dueThisMonth'] = KaryawanModel::whereMonth('tgl_sts_efektif_akhir', date('m'))
                ->whereYear('tgl_sts_efektif_akhir', date('Y'))
                ->whereIn('id_status_karyawan', [1, 2])->get()->count();
        $data['due30days'] = KaryawanModel::whereBetween('tgl_sts_efektif_akhir', [$toDay, $day30])
                ->whereIn('id_status_karyawan', [1, 2])->get()->count();

        //summary
        $data['c_harian'] = KaryawanModel::where('id_status_karyawan', 7)->get()->count();
        $data['c_training'] = KaryawanModel::where('id_status_karyawan', 1)->get()->count();
        $data['c_kontrak'] = KaryawanModel::where('id_status_karyawan', 2)->get()->count();
        $data['c_tetap'] = KaryawanModel::where('id_status_karyawan', 3)->get()->count();
        $data['c_resign'] = KaryawanModel::where('id_status_karyawan', 4)->get()->count();
        $data['c_pensiun'] = KaryawanModel::where('id_status_karyawan', 6)->get()->count();

        return view('HRD.perubahan_status.index', $data);
    }
    public function filter_data(Request $request)
    {
        $toDay = date("Y-m-d");
        $day30 = date('Y-m-d', strtotime($toDay . ' +30 day'));
        $kategori = $request->kategori;
        if($kategori=='duetoday') {
            $keterangan = hrdfunction::get_hari_ini($toDay).', '.date('d').' '.hrdfunction::get_nama_bulan(date('m')). ' '.date('Y');
            $result = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)->whereIn('id_status_karyawan', [1, 2])->get();
        } elseif($kategori=='duethismonth') {
            $keterangan = hrdfunction::get_nama_bulan(date('m')). ' '.date('Y');
            $result = KaryawanModel::whereMonth('tgl_sts_efektif_akhir', date('m'))
                ->whereYear('tgl_sts_efektif_akhir', date('Y'))
                ->whereIn('id_status_karyawan', [1, 2])->get();
        } else {
            $keterangan = "30 hari kedepan";
            $result = KaryawanModel::whereBetween('tgl_sts_efektif_akhir', [$toDay, $day30])
                ->whereIn('id_status_karyawan', [1, 2])->get();
        }
        $data = [
            'list' => $result,
            'keterangan' => $keterangan
        ];
        return view('HRD.perubahan_status.status_karyawan', $data);
    }

    public function baru()
    {
        $all_karyawan = KaryawanModel::whereIn('id_status_karyawan', ['1', '2'])->get();
        $all_status = Config::get('constants.status_karyawan');
        return view('HRD.perubahan_status.baru', ['list_karyawan'=>$all_karyawan, 'list_status'=>$all_status]);
    }
    public function baru_lain($key)
    {
        $id_karyawan = \App\Helpers\Hrdhelper::encrypt_decrypt('decrypt', $key);
        $profil_karyawan = KaryawanModel::find($id_karyawan);
        $all_status = Config::get('constants.status_karyawan');
        $list_riwayat = PerubahanStatusModel::where('id_karyawan', $id_karyawan)->get();
        return view('HRD.perubahan_status.baru_lain', ['profil_karyawan'=>$profil_karyawan, 'list_status'=>$all_status, 'list_riwayat'=>$list_riwayat]);
    }
    public function get_profil(Request $request)
    {
        $result = KaryawanModel::find($request->id_karyawan);

        if(empty($result->tgl_sts_efektif_mulai)) {
            $tgl_sts_efektif_mulai = ""; //date('Y-m-d');
        } else {
            $tgl_sts_efektif_mulai = $result->tgl_sts_efektif_mulai;
        }
        if(empty($result->tgl_sts_efektif_akhir)) {
            $tgl_sts_efektif_akhir = ""; //date('Y-m-d');
        } else {
            $tgl_sts_efektif_akhir = $result->tgl_sts_efektif_akhir;
        }

        $arr_result = array("id_status_lm"=>$result->id_status_karyawan, "nm_status_lm"=>$result->get_status_karyawan($result->id_status_karyawan), "tgl_eff_lm"=> $tgl_sts_efektif_mulai, "tgl_akh_lm"=>$tgl_sts_efektif_akhir, 'no_surat' => $this->buat_nomorsurat_baru());
        echo json_encode($arr_result);
    }
    public function buat_nomorsurat_baru()
    {
        $thn = date('Y');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "PKWT/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = PerubahanStatusModel::orderBy('id', 'desc')->first();
        if(empty($result->no_surat))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_surat, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }
    public function get_riwayat_perubahan_status($id_karyawan)
    {
        $result = PerubahanStatusModel::where('id_karyawan', $id_karyawan)->get();
        return view("HRD.perubahan_status.list_riwayat", ['list_result'=>$result]);
    }
    public function simpan(Request $request)
    {
        PerubahanStatusModel::create([
            'id_karyawan' => $request->pil_karyawan,
            'no_surat' => $request->inp_nomor_surat,
            'tgl_surat' => $request->inp_tgl_surat,
            'tgl_eff_lama' => $request->inp_tgl_eff_lama,
            'tgl_akh_lama' => $request->inp_tgl_akh_lama,
            'id_sts_lama' => $request->inp_id_status_lama,
            'tgl_eff_baru' => $request->tgl_eff_mulai_baru,
            'tgl_akh_baru' => $request->tgl_eff_akhir_baru,
            'id_sts_baru' => $request->pil_sts_baru,
            'no_auto' => 2 //manual
        ]);
        //update status karyawan terbaru
        $update = KaryawanModel::find($request->pil_karyawan);
        $update->id_status_karyawan = $request->pil_sts_baru;
        $update->tgl_sts_efektif_mulai = $request->tgl_eff_mulai_baru;
        $update->tgl_sts_efektif_akhir = $request->tgl_eff_akhir_baru;
        $update->save();
        if($request->frm_baru==1){
            return redirect('hrd/perubahanstatus/baru')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/perubahanstatus')->with('konfirm', 'Data berhasil disimpan');
        }
    }
    public function print($id)
    {
        $id_data = \App\Helpers\Hrdhelper::encrypt_decrypt('decrypt', $id);
        $all_agama = Config::get("constants.agama");
        $result = PerubahanStatusModel::with([
            'get_profil',
            'get_profil.get_jabatan',
            'get_current_approve'])->find($id_data);
        $kop_surat = hrdfunction::get_kop_surat();

        $id_status = (empty($result->id_sts_baru)) ? "" : $result->id_sts_baru;

        $temp_pkwt = $result->get_profil->get_jabatan->file_pkwt;
        if(empty($temp_pkwt)) {
            $pdf = PDF::loadview('HRD.perubahan_status.pkwt.pkwt_ho', [
                'dt_status' => $result,
                'list_agama'=> $all_agama,
                'kop_surat' => $kop_surat
            ])->setPaper('A4', 'potrait');
        } else {
            $pdf = PDF::loadview('HRD.perubahan_status.pkwt.'.$temp_pkwt, [
                'dt_status' => $result,
                'list_agama'=> $all_agama,
                'kop_surat' => $kop_surat
            ])->setPaper('A4', 'potrait');
        }
        // if($id_status<=2 || $id_status==7)
        // {
        //     $pdf = PDF::loadview('HRD.perubahan_status.print_pkwt', [
        //         'dt_status' => $result,
        //         'list_agama'=> $all_agama,
        //         'kop_surat' => $kop_surat
        //     ])->setPaper('A4', 'potrait');

        // } else {
        //     $pdf = PDF::loadview('HRD.perubahan_status.print_sk', [
        //         'dt_status' => $result,
        //         'list_agama'=> $all_agama,
        //         'kop_surat' => $kop_surat
        //     ])->setPaper('A4', 'potrait');
        // }
        return $pdf->stream();
    }
    public function form_proses($id)
    {
        $result = PerubahanStatusModel::find($id);
        $all_status = Config::get('constants.status_karyawan');
        $no_surat = $this->buat_nomorsurat_baru();
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $result->approval_key)->orderBy('approval_level')->get();
        return view('HRD.perubahan_status.proses', ['profil' => $result, 'all_status' => $all_status, 'no_surat' => $no_surat, 'hirarki_persetujuan' => $hirarki_persetujuan]);
    }

    public function store_proses(Request $request)
    {
        $arr_tgl_start = explode("/", $request->tgl_eff_mulai_baru);
        $tgl_start = $arr_tgl_start[2]."-".$arr_tgl_start[1]."-".$arr_tgl_start[0];
        if($request->pil_sts_baru != 3)
        {
            $arr_tgl_end = explode("/", $request->tgl_eff_akhir_baru);
            $tgl_end = $arr_tgl_end[2]."-".$arr_tgl_end[1]."-".$arr_tgl_end[0];
        } else {
            $tgl_end = NULL;
        }

        $id_pengajuan = $request->id_pengajuan;
        $update_pengajuan = PerubahanStatusModel::find($id_pengajuan);
        $update_pengajuan->no_surat = $request->inp_nomor_surat;
        $update_pengajuan->tgl_surat = date("Y-m-d");
        $update_pengajuan->tgl_eff_baru = $tgl_start;
        if($request->pil_sts_baru != 3)
        {
            $update_pengajuan->tgl_akh_baru = $tgl_end;
        }
        $update_pengajuan->no_auto = 2; //auto
        $update_pengajuan->save();
        //update status karyawan terbaru
        $update = KaryawanModel::find($request->id_karyawan);
        $update->id_status_karyawan = $request->pil_sts_baru;
        $update->tgl_sts_efektif_mulai = $tgl_start;
        $update->evaluasi_kerja = NULL;
        $update->kategori_evaluasi_kerja = NULL;
        if($request->pil_sts_baru != 3)
        {
            $update->tgl_sts_efektif_akhir = $tgl_end;
        }
        $update->save();
        if($update){
            return redirect('hrd/perubahanstatus')->with('konfirm', 'Data berhasil disimpan');
        } else {
            return redirect('hrd/perubahanstatus')->with('konfirm', 'Data Gagal disimpan');
        }
    }

    //pengajuan
    public function list_pengajuan()
    {
        $toDay = date("Y-m-d");
        $day30 = date('Y-m-d', strtotime($toDay . ' +30 day'));
        $data['list_jtp_hari_ini'] = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)
                                    ->whereIn('id_status_karyawan', [1, 2])
                                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)->get();

        $data['list_pengajuan'] = PerubahanStatusModel::whereIn('status_pengajuan', [1, 2])
                                    ->whereNull('no_surat')->where('id_departemen', auth()->user()->karyawan->id_departemen)
                                    ->get();
        $data['dueDay'] = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)
                                    ->whereIn('id_status_karyawan', [1, 2])
                                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                                    ->get()->count();
        $data['dueThisMonth'] = KaryawanModel::whereMonth('tgl_sts_efektif_akhir', date('m'))
                                    ->whereYear('tgl_sts_efektif_akhir', date('Y'))
                                    ->whereIn('id_status_karyawan', [1, 2])->where('id_departemen', auth()->user()->karyawan->id_departemen)->get()->count();
        $data['due30days'] = KaryawanModel::whereBetween('tgl_sts_efektif_akhir', [$toDay, $day30])
                                    ->whereIn('id_status_karyawan', [1, 2])
                                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)->get()->count();

        return view('HRD.perubahan_status.pengajuan.index', $data);
    }

    public function filter_data_perdept(Request $request)
    {
        $toDay = date("Y-m-d");
        $day30 = date('Y-m-d', strtotime($toDay . ' +30 day'));
        $kategori = $request->kategori;
        if($kategori=='duetoday') {
            $keterangan = hrdfunction::get_hari_ini($toDay).', '.date('d').' '.hrdfunction::get_nama_bulan(date('m')). ' '.date('Y');
            $result = KaryawanModel::where('tgl_sts_efektif_akhir', $toDay)
                    ->whereIn('id_status_karyawan', [1, 2])
                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                    ->get();
        } elseif($kategori=='duethismonth') {
            $keterangan = hrdfunction::get_nama_bulan(date('m')). ' '.date('Y');
            $result = KaryawanModel::whereMonth('tgl_sts_efektif_akhir', date('m'))
                    ->whereYear('tgl_sts_efektif_akhir', date('Y'))
                    ->whereIn('id_status_karyawan', [1, 2])
                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                    ->get();
        } else {
            $keterangan = "30 hari kedepan";
            $result = KaryawanModel::whereBetween('tgl_sts_efektif_akhir', [$toDay, $day30])
                    ->whereIn('id_status_karyawan', [1, 2])
                    ->where('id_departemen', auth()->user()->karyawan->id_departemen)
                    ->get();
        }
        $data = [
            'list' => $result,
            'keterangan' => $keterangan
        ];
        return view('HRD.perubahan_status.pengajuan.result_filter', $data);
    }

    public function form_pengajuan($id)
    {
        $data['profil'] = KaryawanModel::with([
            'get_jabatan',
            'get_departemen'
        ])->find($id);
        $data['list_status'] = Config::get('constants.status_karyawan');
        return view('HRD.perubahan_status.pengajuan.add', $data);
    }

    public function store_pengajuan(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 5;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $path = storage_path("app/public/hrd/hasil_evaluasi_karyawan");
            if(!File::isDirectory($path)) {
                $path = Storage::disk('public')->makeDirectory('hrd/hasil_evaluasi_karyawan');
            }
            $file = $request->file('inp_file_evaluasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/hrd/hasil_evaluasi_karyawan', $filename);

            $exec_store = PerubahanStatusModel::create([
                'id_karyawan' => $request->pil_karyawan,
                'tgl_eff_lama' => $request->inp_tgl_eff_lama,
                'tgl_akh_lama' => $request->inp_tgl_akh_lama,
                'id_sts_lama' => $request->inp_id_status_lama,
                'id_sts_baru' => $request->pil_sts_baru,
                'tgl_pengajuan' => date('Y-m-d'),
                'alasan_pengajuan' => $request->inp_alasan,
                'id_departemen' => auth()->user()->karyawan->id_departemen,
                'diajukan_oleh' => auth()->user()->karyawan->id,
                'id_user' => auth()->user()->id,
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
                SubmissionHrd::update_current_status($request->pil_karyawan);
                return redirect('hrd/perubahanstatus/list_pengajuan')->with('konfirm', 'Data berhasil disimpan');
            } else {
                return redirect('hrd/perubahanstatus/list_pengajuan')->with('konfirm', 'Data Gagal disimpan');
            }
        } else {
            return redirect('hrd/perubahanstatus/list_pengajuan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    public function detail_pengajuan($id)
    {
        $queryResult = PerubahanStatusModel::with([
            'get_profil',
            'get_departemen',
            'get_current_approve',
            'get_diajukan_oleh'
        ])->find($id);
        $data = [
            'data' => $queryResult,
            'hirarki_persetujuan' => ApprovalModel::where('approval_key', $queryResult->approval_key)->orderBy('approval_level')->get()
        ];

        return view('HRD.perubahan_status.pengajuan.detail', $data);
    }

    public function download_hasil_evaluasi($id)
    {
        $file = PerubahanStatusModel::find($id);
        $pathToFile = $file->file_hasil_evaluasi;
        $path = storage_path('app/public/hrd/hasil_evaluasi_karyawan/'.$pathToFile);
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$pathToFile.'"'
        ]);
    }
}
