<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\ThrTemplate;
use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use App\Imports\PeriodeThrImport;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\ThrDetailModel;
use App\Models\HRD\ThrModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ThrController extends Controller
{
    public function index()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_thr'] = ThrModel::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('HRD.penggajian.thr.index', $data);
    }
    public function simpanPeriodeThr(Request $request)
    {
        try {
            $bulan = $request->pil_periode_bulan;
            $tahun = $request->inp_periode_tahun;
            $_uuid = Str::uuid();
            $checkData = ThrModel::where('bulan', $bulan)->where('tahun', $tahun)->get()->count();
            if($checkData==0)
            {
                $dataInsert = [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'approval_key' => $_uuid,
                    'is_draft' => 1,
                    'diajukan_oleh' => auth()->user()->id
                ];
                ThrModel::create($dataInsert);
                $status = true;
                $msg = "Data berhasil disimpan";
            } else {
                $status = false;
                $msg = "Periode pemberian bonus sudah ada..";
            }
        } catch (Throwable $e) {
            Log::error('Transaction failed: '.$e->getMessage());
            $status = false;
            $msg = "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }

    public function downloadtemplateThr($tahun, $bulan)
    {
        return Excel::download(new ThrTemplate($tahun, $bulan), 'templatePeriodeThrKaryawan.xlsx');
    }

    public function formImportPeriodeThr($key)
    {
        $checkData = ThrModel::where('approval_key', $key)->count();
        if($checkData==0)
        {
             return redirect('hrd/thr_karyawan');
        } else {
            $data = [
                'id_head' => ThrModel::where('approval_key', $key)->first()->id
            ];
            return view("HRD.penggajian.thr.form_import", $data);
        }
    }

    public function doImportPeriodeThr(Request $request)
    {
        try {
            Excel::import(new PeriodeThrImport($request->id_head), request()->file_imp);
            return back()->withStatus('Excel file import succesfully');
        } catch (\Exception $ex) {
            return back()->withStatus($ex->getMessage());
        }
    }

    public function detailThr($id)
    {
        $data = [
            'periode' => ThrModel::find($id),
            'departemen' => DepartemenModel::all()
        ];

        return view('HRD.penggajian.thr.form_detail', $data);
    }

    public function getDataThr(Request $request)
    {
        $columns = ['created_at'];
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $id_dept = $request->input('id_dept');
        if($id_dept==0)
        {
            $totalData = KaryawanModel::where(function ($q) {
                $q->whereNull('id_departemen')
                    ->orWhere('id_departemen', 0);
                })->whereIn('id_status_karyawan', [1, 2, 3, 7])->get()->count();
            $search = $request->input('search.value');

            $query = KaryawanModel::with([
                'get_jabatan'
            ])
            ->where(function ($q) {
                $q->whereNull('id_departemen')
                    ->orWhere('id_departemen', 0);
                })
            ->whereIn('id_status_karyawan', [1, 2, 3, 7]);

            if(!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->Where('nm_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
                });
            }
            $totalFiltered = $query->count();
            $query = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            // ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->orderBy('tgl_masuk', 'desc')
            ->orderBy('nik')
            ->get()->map( function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $query = ThrDetailModel::where('id_karyawan', $arr['id'])
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);
                if($query->get()->count() == 0)
                {
                    $arr['payrol'] = null;
                } else {
                    $arr['payrol'] = $query->first();

                }
                return $arr;
            });


        } else {
            $totalData = KaryawanModel::where('id_departemen', $id_dept)
                        ->whereIn('id_status_karyawan', [1, 2, 3])->get()->count();
            $search = $request->input('search.value');

            $query = KaryawanModel::with([
                'get_jabatan'
                ])
                ->where('id_departemen', $id_dept)
                ->whereIn('id_status_karyawan', [1, 2, 3]);

            if(!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->Where('nm_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
                });
            }
            $totalFiltered = $query->count();
            $query = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            // ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->orderBy('id_jabatan')
            ->orderBy('tgl_masuk', 'desc')
            ->orderBy('nik')
            ->get()->map( function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $query = ThrDetailModel::where('id_karyawan', $arr['id'])
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);
                if($query->get()->count() == 0)
                {
                    $arr['payrol'] = null;
                } else {
                    $arr['payrol'] = $query->first();

                }
                return $arr;
            });
        }
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            $ket_status = "";
            foreach($query as $r){
                if($r['id_status_karyawan']==1)
                {
                    $badge_thema = 'badge iq-bg-info';
                } elseif($r['id_status_karyawan']==2) {
                    $badge_thema = 'badge iq-bg-primary';
                } elseif($r['id_status_karyawan']==3) {
                    $badge_thema = 'badge iq-bg-success';
                } elseif($r['id_status_karyawan']==7) {
                    $badge_thema = 'badge iq-bg-warning';
                } else {
                    $badge_thema = 'badge iq-bg-danger';
                }

                $list_status = Config::get('constants.status_karyawan');
                foreach($list_status as $key => $value)
                {
                    if($key==$r['id_status_karyawan'])
                    {
                        $ket_status = $value;
                        break;
                    }
                }
                $status = "<span class='".$badge_thema."'>".$ket_status."</span>";
                if($r['payrol']==null)
                {
                    $gapok = $r['gaji_pokok'];
                    $tunj_tetap = 0;
                    $total = 0;
                } else {
                    $gapok = $r['payrol']['gaji_pokok'];
                    $tunj_tetap = $r['payrol']['tunj_tetap'];
                    $total = $gapok + $tunj_tetap;
                }
                $Data['no'] = $counter;
                $Data['karyawan'] = $r['nik']." - ".$r['nm_lengkap'];
                $Data['posisi'] = (!empty($r['id_jabatan']) ? $r['get_jabatan']['nm_jabatan'] : "");
                $Data['status'] = $status;
                $Data['gapok'] = number_format($r['gaji_pokok'], 0);
                $Data['tunjangan_tetap'] =  number_format($tunj_tetap, 0);
                $Data['total'] = number_format($total, 0);
                $data[] = $Data;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function detailPengaturan($id_dept, $bulan, $tahun)
    {
        if($id_dept==0)
        {
            $dataPayroll = KaryawanModel::with([
                'get_jabatan'
            ])
            ->where(function ($q) {
                $q->whereNull('id_departemen')
                    ->orWhere('id_departemen', 0);
                })
            ->whereIn('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('tgl_masuk', 'desc')
            ->orderBy('nik')
            ->get()->map( function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $query = ThrDetailModel::where('id_karyawan', $arr['id'])
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);
                if($query->get()->count() == 0)
                {
                    $arr['payrol'] = null;
                } else {
                    $arr['payrol'] = $query->first();

                }
                return $arr;
            });
        } else {
            $dataPayroll = KaryawanModel::with([
                'get_jabatan'
            ])
            ->where('id_departemen', $id_dept)
            ->whereIn('id_status_karyawan', [1, 2, 3])
            ->orderBy('id_jabatan')
            ->orderBy('tgl_masuk', 'desc')
            ->orderBy('nik')
            ->get()->map( function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $query = ThrDetailModel::where('id_karyawan', $arr['id'])
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);
                if($query->get()->count() == 0)
                {
                    $arr['payrol'] = null;
                } else {
                    $arr['payrol'] = $query->first();

                }
                return $arr;
            });
        }
        $data = [
            'id_departemen' => $id_dept,
            'nama_departemen' => ($id_dept==0) ? "Non Departemen" : DepartemenModel::find($id_dept)->nm_dept,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $dataPayroll,
        ];
        return view('HRD.penggajian.thr.detail_pengaturan', $data);
    }

    public function formPengaturan($id_karyawan, $bulan, $tahun)
    {
        $karyawan = KaryawanModel::find($id_karyawan);
        if($bulan==1) {
            $last_bulan = 12;
            $last_tahun= $tahun - 1;
        } else {
            $last_bulan = $bulan - 1;
            $last_tahun = $tahun;
        }
        $last_payroll = ThrDetailModel::where('id_karyawan', $id_karyawan)->where('bulan', $last_bulan)->where('tahun', $last_tahun)->first();
        $current_payroll = ThrDetailModel::where('id_karyawan', $id_karyawan)->where('bulan', $bulan)->where('tahun', $tahun)->first();
        $thrHead = ThrModel::where('bulan', $bulan)->where('tahun', $tahun)->first();

        //potongan sedekah
        if(empty($current_payroll->gaji_pokok)) {
            $gaji_pokok = (empty($last_payroll->gaji_pokok)) ? $karyawan->gaji_pokok : $last_payroll->gaji_pokok;
        } else {
            $gaji_pokok = $current_payroll->gaji_pokok;
        }
        if(empty($current_payroll->tunj_tetap)) {
            $tunj_tetap = (empty($last_payroll->tunj_tetap)) ? 0 : $last_payroll->tunj_tetap;
        } else {
            $tunj_tetap = $current_payroll->tunj_tetap;
        }
        $data = [
            'profil' => $karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'gaji_pokok' => $gaji_pokok,
            'tunjangan_tetap' => $tunj_tetap,
            'id_head' => $thrHead->id
        ];
        return view('HRD.penggajian.thr.form_pengaturan', $data);
    }

    public function simpanPengaturan(Request $request)
    {
        try {
            $checkData = ThrDetailModel::where('id_karyawan', $request->id_karyawan)
                                ->where('bulan', $request->periode_bulan)
                                ->where('tahun', $request->periode_tahun);
            if($checkData->get()->count() == 0)
            {
                ThrDetailModel::create([
                    "id_head"=> $request->id_head,
                    "id_karyawan"=> $request->id_karyawan,
                    "id_departemen" => $request->id_departemen,
                    "bulan" => $request->periode_bulan,
                    "tahun" => $request->periode_tahun,
                    "gaji_pokok" => str_replace(",","", $request->inpGapok),
                    "tunj_tetap" => str_replace(",","", $request->inpTunjTetap),
                ]);
            } else {
                $dataPayroll = $checkData->first();
                $update = ThrDetailModel::find($dataPayroll->id);
                $update->gaji_pokok = str_replace(",","", $request->inpGapok);
                $update->tunj_tetap = str_replace(",","", $request->inpTunjTetap);
                $update->save();
            }
            $status = true;
            $msg = "Data berhasil disimpan";
        } catch (Throwable $e) {
            Log::error('Transaction failed: '.$e->getMessage());
            $status = false;
            $msg = "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage();
        }


        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
        // return redirect('hrd/thr_karyawan/detailPengaturan/'.$request->id_departemen."/".$request->periode_bulan."/".$request->periode_tahun)->with('konfirm', 'Data berhasil disimpan');
    }

    public function submitThr($bulan, $tahun, $uuid)
    {
        $resNonDepartemen = KaryawanModel::with(['get_jabatan'])->whereNull('id_departemen')->where('nik', '<>', '999999999')->get()
            ->map(function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $id_karyawan = $arr['id'];
                $payrollData = ThrDetailModel::where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->where('id_karyawan', $id_karyawan)
                    ->first();
                // $list_data = $payrollData;
                // dd($list_data);
                $arr['list_data'] = [
                    'id_karyawan' => $id_karyawan,
                    'gaji_pokok' => $payrollData->gaji_pokok ?? 0,
                    'tunj_tetap' => $payrollData->tunj_tetap ?? 0,
                    // Tambahkan data lain sesuai kebutuhan
                ];
                return $arr;
            });
        $resPenggajian = DepartemenModel::where('status', 1)->get()->map( function ($row) use ($bulan, $tahun) {
            $arr = $row->toArray();
            // Ambil semua karyawan di departemen ini
            $karyawan = KaryawanModel::with(['get_jabatan'])->whereIn('id_status_karyawan', [1, 2, 3, 7])->where('id_departemen', $arr['id'])->get();
            $payrollData = ThrDetailModel::where('id_departemen', $arr['id'])
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->get()
                ->keyBy('id_karyawan'); // agar bisa dicari cepat
            // Gabungkan data karyawan + payroll (jika ada)
            $list_data = $karyawan->map(function ($karyawan) use ($payrollData) {
                $payroll = $payrollData->get($karyawan->id);
                return [
                    'id_karyawan' => $karyawan->id,
                    'nm_lengkap' => $karyawan->nm_lengkap,
                    'nik' => $karyawan->nik,
                    'jabatan' => $karyawan->get_jabatan->nm_jabatan,
                    'id_status_karyawan' => $karyawan->id_status_karyawan,
                    'gaji_pokok' => $payroll->gaji_pokok ?? 0,
                    'tunj_tetap' => $payroll->tunj_tetap ?? 0,
                ];
            });
            $arr['list_data'] = $list_data;
            return $arr;
        });
        // dd($resPenggajian);
        $data = [
            'periode' => Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'uuid_periode' => $uuid,
            'data' => $resPenggajian,
            'data_non_dept' => $resNonDepartemen,
            'list_status' => Config::get("constants.status_karyawan")
        ];
        return view('HRD.penggajian.thr.form_submit', $data);
    }

     public function storeSubmitThr(Request $request)
    {
        try {
            $bulan = $request->periode_bulan;
            $tahun = $request->periode_tahun;
            $_uuid = $request->periode_uuid;

            $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
            $group = 18; //pengajuan /THR
            $ifSet = Hrdhelper::set_approval_cek($group, $id_depat_karyawan);
            if($ifSet > 0)
            {
                $dataH = ThrModel::where('bulan', $bulan)->where('tahun', $tahun)->where('approval_key', $_uuid)->first();
                $dataUpdateHead = [
                    'status_pengajuan' => 1,
                    'current_approval_id' => Hrdhelper::set_approval_get_first($group, $id_depat_karyawan),
                ];
                ThrModel::find($dataH->id)->update($dataUpdateHead);
                $arr_appr =  Hrdhelper::set_approval_new($group, $id_depat_karyawan);
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
                $status = true;
                $msg = "Data berhasil disimpan";
            } else {
                $status = false;
                $msg = 'Matriks persetujuan belum diatur';
            }
        } catch (Throwable $e) {
            Log::error('Transaction failed: '.$e->getMessage());
            $status = false;
            $msg = "Terdapat error pada proses penyimpanan data. error: ".$e->getMessage();
        }


        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }
}
