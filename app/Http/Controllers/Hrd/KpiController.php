<?php

namespace App\Http\Controllers\Hrd;

use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\KPIMasterModel;
use App\Models\HRD\KPIModel;
use App\Models\HRD\KPIPeriodikDetailModel;
use App\Models\HRD\KPIPeriodikLampiranModel;
use App\Models\HRD\KPIPeriodikModel;
use App\Models\HRD\KPISatuanModel;
use App\Models\HRD\KPITipeModel;
use App\Traits\HasUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class KpiController extends Controller
{
    use HasUpload;
    //Penyusunan KPI oleh HRD
    public function index()
    {
        $currentYear = date("Y");
        $startYear = '2022';
        $data = [
            'currentYear' => $currentYear,
            'startYear' => $startYear,
            'listBulan' => Config::get("constants.bulan"),
            'allDepartemen' => DepartemenModel::where('status', 1)->get()
        ];
        return view('HRD.kpi.penyusunan.index', $data);
    }

    public function getKPI($dept, $tahun, $bulan)
    {
        $kpiSetup = [];
        $idHead = "";
        $statusSetup = "draft";
        $dataExists = KPIPeriodikModel::where('bulan', $bulan)->where('tahun', $tahun)->where('id_departemen', $dept);
        if(!$dataExists->exists()) {
            $masterKPI = KPIMasterModel::with([
                'tipeKPI',
                'satuanKPI'
                ])->where('id_departemen', $dept)->get();

            foreach($masterKPI as $r) {
                $kpiSetup[] = [
                    'id_detail' => "",
                    'id_kpi' => $r->id,
                    'nama_kpi' => $r->nama_kpi,
                    'tipe_kpi' => $r->TipeKPI->tipe_kpi,
                    'satuan_kpi' => $r->SatuanKPI->satuan_kpi,
                    'bobot_kpi' => $r->bobot_kpi,
                    'target_kpi' => 0
                ];
            }
        } else {
            $dataHead = $dataExists->first();
            $idHead = $dataHead->id;
            $statusSetup = $dataHead->status;
            $kpiExisting = KPIPeriodikDetailModel::with([
                'getKPIMaster',
                'getKPIMaster.TipeKPI',
                'getKPIMaster.SatuanKPI',
            ])->where('id_head', $idHead)->get();
            foreach($kpiExisting as $r) {
                $kpiSetup[] = [
                    'id_detail' => $r->id,
                    'id_kpi' => $r->getKPIMaster->id,
                    'nama_kpi' => $r->getKPIMaster->nama_kpi,
                    'tipe_kpi' => $r->getKPIMaster->TipeKPI->tipe_kpi,
                    'satuan_kpi' => $r->getKPIMaster->SatuanKPI->satuan_kpi,
                    'bobot_kpi' => $r->getKPIMaster->bobot_kpi,
                    'target_kpi' => $r->target
                ];
            }

        }
        $data = [
            'currentMonth' => Hrdhelper::get_nama_bulan($bulan). " ".$tahun, // $this->getRangeBulan(date('m')),
            'namaDept' => DepartemenModel::find($dept)->nm_dept,
            'listKPIDepartemen' => $kpiSetup,
            'idHead' => $idHead,
            'statusSetup' => $statusSetup
        ];
        return view('HRD.kpi.penyusunan.form_pengaturan', $data);
    }

    function getRangeBulan($currentMonth)
    {
        $monthText = Hrdhelper::get_nama_bulan($currentMonth);
        $usesMonth = [];
        $allBulan = Config::get("constants.bulan");
        foreach($allBulan as $r) {
            $usesMonth[] = $r;

            if ($r == $monthText) {
                break;
            }
        }
        return $usesMonth;
    }

    public function storeKPIDepartemen(Request $request)
    {
        DB::beginTransaction();
        try {
            $idHead = $request->idHeAD;
            $status = "draft";
            if($request->action=="posting")
            {
                $status = "posting";
            }

            if(empty($idHead)) {
                $dataH = [
                    'id_departemen' => $request->pil_dept,
                    'bulan' => $request->pil_bulan,
                    'tahun' => $request->pil_tahun,
                    'status' => $status,
                    'user_created' => auth()->user()->id
                ];
                $lastID = KPIPeriodikModel::insertGetId($dataH);
                if($lastID)
                {
                    $jml_item = count($request->id_kpi);
                    foreach(array($request) as $key => $value)
                    {
                        for($i=0; $i<$jml_item; $i++)
                        {
                            $dataD = [
                                "id_head" => $lastID,
                                "id_kpi" => $value['id_kpi'][$i],
                                "bobot" => $value['bobot_kpi'][$i],
                                "target" => $value['target'][$i],
                            ];

                            KPIPeriodikDetailModel::insert($dataD);
                        }
                    }
                }
            } else {
                KPIPeriodikModel::find($idHead)->update(['status' => $status]);
                $jml_item = count($request->id_kpi);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $idDetail = $value['id_detail_kpi'][$i];
                        $dataD = [
                            "target" => $value['target'][$i],
                        ];
                        if(!empty($idDetail))
                        {
                            KPIPeriodikDetailModel::find($idDetail)->update($dataD);
                        }
                    }
                }
            }

            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback on error
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    //Penilaian
    public function penilaian()
    {
        if(auth()->user()->can('key_performance_indicator_penilaian_view')) {
            $userDept = auth()->user()->karyawan->id_departemen;
            $currentYear = date("Y");
            $data = [
                'kpiClosed' => KPIPeriodikModel::where('id_departemen', $userDept)->where('tahun', $currentYear)->where('status', 'closed')->get(),
                'kpiPosting' => KPIPeriodikModel::where('id_departemen', $userDept)->where('tahun', $currentYear)->where('status', 'posting')->get(),
                'kpiApproval' => KPIPeriodikModel::where('id_departemen', $userDept)->where('tahun', $currentYear)->where('status', 'approval')->get(),
                'helper' => Hrdhelper::class
            ];
            return view('HRD.kpi.penilaian.index', $data);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    public function form_penilaian($id)
    {
        if(auth()->user()->can('key_performance_indicator_penilaian_view')) {
            $result = KPIPeriodikModel::find($id);
            $data = [
                'headKPI' => $result,
                'periode_kpi' => Hrdhelper::get_nama_bulan($result->bulan). " ".$result->tahun,
                'detailKPI' => KPIPeriodikDetailModel::with([
                    'getKPIMaster',
                    'getKPIMaster.tipeKPI',
                    'getKPIMaster.satuanKPI'
                ])->where('id_head', $id)->get(),
                'LampiranKPI' => KPIPeriodikDetailModel::with([
                    'getKPIMaster',
                    'getKPIMaster.tipeKPI',
                    'getKPIMaster.satuanKPI'
                ])->where('id_head', $id)->get()->map( function($newRow) use ($id){
                    $arr = $newRow->toArray();
                    $arr['lampiran'] = KPIPeriodikLampiranModel::where('id_head', $id)->where('id_detail_kpi', $arr['id'])->get();
                    return $arr;
                })
            ];
            // dd($data);
            return view('HRD.kpi.penilaian.form_penilaian', $data);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function storePenilaianKPIDepartemen(Request $request)
    {
        DB::beginTransaction();
        try {
            $userDept = auth()->user()->karyawan->id_departemen;
            $idHead = $request->idHeAD;
            $status = "posting";
            if($request->action=="submit")
            {
                $status = "approval";
                $_uuid = Str::uuid();
                $group = 19;
                $ifSet = Hrdhelper::set_approval_cek($group, $userDept);
                if($ifSet > 0)
                {
                    $dataH = [
                        'submit_at' => date('Y-m-d'),
                        'user_submit' => auth()->user()->id,
                        'status' => $status,
                        'total_kpi' => $request->total_nilai_kpi,
                        'status_pengajuan' => 1,
                        'approval_key' => $_uuid,
                        'current_approval_id' => Hrdhelper::set_approval_get_first($group, $userDept),
                        'diajukan_oleh' => auth()->user()->id,
                    ];
                    KPIPeriodikModel::find($idHead)->update($dataH);
                    $jml_item = count($request->id_kpi);
                    foreach(array($request) as $key => $value)
                    {
                        for($i=0; $i<$jml_item; $i++)
                        {
                            $idDetail = $value['id_detail_kpi'][$i];
                            $dataD = [
                                "nama_kpi" => $value['nama_kpi'][$i],
                                "tipe" => $value['tipe_kpi'][$i],
                                "satuan" => $value['satuan_kpi'][$i],
                                "bobot" => $value['bobot_kpi'][$i],
                                "realisasi" => $value['realisasi'][$i],
                                "skor_akhir" => $value['skor_akhir'][$i],
                                "nilai_kpi" => $value['nilai_akhir'][$i],
                            ];
                            if(!empty($idDetail))
                            {
                                KPIPeriodikDetailModel::find($idDetail)->update($dataD);
                            }
                        }
                    }
                    $arr_appr =  Hrdhelper::set_approval_new($group, $userDept);
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
                    DB::commit(); // Commit Transaction if everything is successful
                    $rs = response()->json([
                        'success' => true,
                        'message' => "Data berhasil disimpan."
                    ]);
                } else {
                    $rs = response()->json([
                        'success' => false,
                        'message' => "Matriks persetujuan belum diatur."
                    ]);
                }

            } else {
                $dataH = [
                'status' => $status,
                'total_kpi' => $request->total_nilai_kpi
                ];
                KPIPeriodikModel::find($idHead)->update($dataH);
                $jml_item = count($request->id_kpi);
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i<$jml_item; $i++)
                    {
                        $idDetail = $value['id_detail_kpi'][$i];
                        $dataD = [
                            "realisasi" => $value['realisasi'][$i],
                            "skor_akhir" => $value['skor_akhir'][$i],
                            "nilai_kpi" => $value['nilai_akhir'][$i],
                        ];
                        if(!empty($idDetail))
                        {
                            KPIPeriodikDetailModel::find($idDetail)->update($dataD);
                        }
                    }
                }
                DB::commit(); // Commit Transaction if everything is successful
                $rs = response()->json([
                    'success' => true,
                    'message' => "Data berhasil disimpan."
                ]);
            }

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback on error
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    public function formUploadLampiran($id)
    {
        $data = [
            'profil' => KPIPeriodikDetailModel::with([
                'getKPIPeriodik',
                'getKPIMaster'
            ])->find($id)
        ];
        return view('HRD.kpi.penilaian.form_upload_lampiran', $data);
    }

    public function storeLampiran(Request $request)
    {
        DB::beginTransaction();
        try {
            $folder = "hrd/performance/kpi-".$request->periode_bulan.$request->periode_tahun.$request->id_dept;
            $filename = HasUpload::handleFileUpload($request, 'inp_file', '', $folder);
            $data = [
                "id_head" => $request->id_head,
                'id_detail_kpi' => $request->id_kpi,
                "keterangan" => $request->inp_keterangan,
                "file_lampiran" => $filename,
            ];
            KPIPeriodikLampiranModel::create($data);
            DB::commit(); // Commit Transaction if everything is successful
            $rs = response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan."
            ]);
        } catch (Throwable $e) {
            DB::rollBack(); // Rollback on error
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    public function deleteLampiranKPI($id)
    {
        DB::beginTransaction();
        try {
            $lampiran = KPIPeriodikLampiranModel::with(['kpiPeriodik'])->find($id);
            if (!$lampiran || !$lampiran->file_lampiran) {
                return abort(404, 'Lampiran tidak ditemukan');
            }
            // $path = $lampiran->file_lampiran;
            $relativePath  = Str::after($lampiran->file_lampiran, 'public/');
            $fileDeleted = HasUpload::hapusFile($relativePath);

            if($fileDeleted) {
                $lampiran->delete();
                DB::commit(); // Commit Transaction if everything is successful
                $rs = response()->json([
                    'success' => true,
                    'message' => "Data berhasil dihapus."
                ]);
            } else {
                DB::rollBack();
                $rs = response()->json([
                    'success' => false,
                    'message' => "File gagal dihapus dari server."
                ]);
            }

        } catch (Throwable $e) {
            DB::rollBack(); // Rollback on error
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data ".$e->getMessage()
            ]);
        }
        return $rs;
    }

    public function kpiPeriodik($id)
    {
        if(auth()->user()->can('key_performance_indicator_penilaian_view')) {
            $result = KPIPeriodikModel::find($id);
            $data = [
                'headKPI' => $result,
                'periode_kpi' => Hrdhelper::get_nama_bulan($result->bulan). " ".$result->tahun,
                'detailKPI' => KPIPeriodikDetailModel::with([
                    'getKPIMaster',
                    'getKPIMaster.tipeKPI',
                    'getKPIMaster.satuanKPI'
                ])->where('id_head', $id)->get(),
                'LampiranKPI' => KPIPeriodikDetailModel::with([
                        'getKPIMaster',
                        'getKPIMaster.tipeKPI',
                        'getKPIMaster.satuanKPI'
                    ])->where('id_head', $id)->get()->map( function($newRow) use ($id){
                        $arr = $newRow->toArray();
                        $arr['lampiran'] = KPIPeriodikLampiranModel::where('id_head', $id)->where('id_detail_kpi', $arr['id'])->get();
                        return $arr;
                })
            ];
            return view('HRD.kpi.penilaian.kpi_periodik', $data);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function showDetail($id)
    {
        $data = [
            'detail' => KPIMasterModel::find($id)
        ];
        return view('HRD.kpi.detail', $data);
    }

    //download lampiran data pendukung
    public function downloadLampiranKPI($id)
    {
        $lampiran = KPIPeriodikLampiranModel::with(['kpiPeriodik'])->find($id);
        if (!$lampiran || !$lampiran->file_lampiran) {
            return abort(404, 'Lampiran tidak ditemukan');
        }
        // $path = $lampiran->file_lampiran;
        $relativePath  = Str::after($lampiran->file_lampiran, 'public/');

        $filename = basename($lampiran->file_lampiran);
        $fullPath = storage_path('app/public/' . $relativePath);
        if (!file_exists($fullPath)) {
            return abort(404, 'File tidak tersedia di server.');
        }
        return response()->download($fullPath, $filename);
    }
}
