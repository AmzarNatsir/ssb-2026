<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\PenggajianTemplate;
use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use App\Imports\PeriodePenggajianImport;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\SetupBPJSModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\PayrollHeaderModel;
use App\Models\HRD\PayrollModel;
use App\Models\HRD\PinjamanKaryawanModel;
use App\Models\HRD\PotonganGajiKaryawanModel;
use App\Services\PayrollImportValidator;
use App\Traits\Payroll;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Config as FacadesConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PenggajianController extends Controller
{
    use Payroll;
    public function index()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['PeriodePenggajian'] = PayrollHeaderModel::where('tahun', date('Y'))->orderby('bulan')->get();
        return view('HRD.penggajian.index', $data);
    }
    //step 1
    public function simpanPeriodePenggajian(Request $request)
    {
        try {
            $bulan = $request->pil_periode_bulan;
            $tahun = $request->inp_periode_tahun;
            $_uuid = Str::uuid();
            $checkData = PayrollHeaderModel::where('bulan', $bulan)->where('tahun', $tahun)->get()->count();
            if($checkData==0)
            {
                $dataInsert = [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'approval_key' => $_uuid,
                    'is_draft' => 1,
                    'diajukan_oleh' => auth()->user()->id
                ];
                PayrollHeaderModel::create($dataInsert);
                $status = true;
                $msg = "Data berhasil disimpan";
            } else {
                $status = false;
                $msg = "Periode Penggajian sudah dibuat..";
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
    //step 2
    public function detailPeriodePenggajian($id)
    {
        $data = [
            'periode' => PayrollHeaderModel::find($id),
            'departemen' => DepartemenModel::all()
        ];

        return view('HRD.penggajian.detail_periode', $data);
    }
    public function getDataPenggajian(Request $request)
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
                $query = PayrollModel::where('id_karyawan', $arr['id'])
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
                $query = PayrollModel::where('id_karyawan', $arr['id'])
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
                $tunj_perusahaan = 0;
                $tunj_tetap = 0;
                $hours_meter = 0;
                $lembur = 0;
                $tot_tunjangan = 0;
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

                $list_status = FacadesConfig::get('constants.status_karyawan');
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
                    $pot_bpjs_ks = 0;
                    $pot_jht = 0;
                    $pot_jp = 0;
                    $pot_jkk = 0;
                    $pot_jkm = 0;
                    $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkk + $pot_jkm;
                    $tunj_bpjs_perusahaan = 0;
                    $total_tunj_perusahaan = 0;
                    $gaji_bruto=0;
                    $thp = 0;
                } else {
                    $gapok = $r['payrol']['gaji_pokok'];
                    //potongan
                    $pot_bpjs_ks = (empty($r['payrol']['bpjsks_karyawan'])) ? 0 : $r['payrol']['bpjsks_karyawan'];
                    $pot_jht = (empty($r['payrol']['bpjstk_jht_karyawan'])) ? 0 : $r['payrol']['bpjstk_jht_karyawan'];
                    $pot_jp = (empty($r['payrol']['bpjstk_jp_karyawan'])) ? 0 : $r['payrol']['bpjstk_jp_karyawan'];
                    $pot_jkk = (empty($r['payrol']['bpjstk_jkk_karyawan'])) ? 0 : $r['payrol']['bpjstk_jkk_karyawan'];
                    $pot_jkm = (empty($r['payrol']['bpjstk_jkm_karyawan'])) ? 0 : $r['payrol']['bpjstk_jkm_karyawan'];
                    $pot_sedekah = $r['payrol']['pot_sedekah'];
                    $pot_pkk = $r['payrol']['pot_pkk'];
                    $pot_air = $r['payrol']['pot_air'];
                    $pot_rumah = $r['payrol']['pot_rumah'];
                    $pot_toko_alif = $r['payrol']['pot_toko_alif'];
                    $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkk + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                    //tunjangan
                    $total_tunj_perusahaan = $r['payrol']['tunj_perusahaan'] ?? 0;
                    $tunj_bpjs_perusahaan = $r['payrol']['tunj_ppot_tunj_perusahaanerusahaan'] ?? 0;
                    $gaji_bruto = $gapok + $total_tunj_perusahaan + $tunj_bpjs_perusahaan;
                    //thp
                    $thp = $gaji_bruto - $tunj_bpjs_perusahaan - $tot_potongan;
                }
                $act_tunjangan = "";
                $act_potongan = "";
                if(!empty($r['gaji_pokok']))
                {
                    $act_tunjangan = '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalFormDetail" onclick="detailTunjangan(this)" id="'. $r['id'].'">'.number_format($total_tunj_perusahaan, 0).'</button>';
                }
                if(!empty($r['gaji_pokok']))
                {
                    $act_potongan = '<div class="btn-group mb-1 dropup">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalFormDetail" onclick="detailPotongan(this)" id="'. $r['id'].'">'.number_format($tot_potongan, 0).'</button>';
                }

                $Data['no'] = $counter;
                $Data['karyawan'] = $r['nik']." - ".$r['nm_lengkap'];
                $Data['posisi'] = (!empty($r['id_jabatan']) ? $r['get_jabatan']['nm_jabatan'] : "");
                $Data['status'] = $status;
                $Data['gapok'] = number_format($r['gaji_pokok'], 0);
                $Data['tunjangan'] = $act_tunjangan;
                $Data['gaji_bruto'] = number_format($gaji_bruto, 0);
                $Data['potongan'] = $act_potongan;
                $Data['thp'] = number_format($thp, 0);
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

    //step 3
    public function pengaturanPenggajian($id_dept, $bulan, $tahun)
    {
        $res_persen_bpjs = SetupBPJSModel::first();
        if($id_dept==0)
        {
            $dataPayroll = KaryawanModel::with([
                'get_jabatan'
            ])
            ->where(function ($q) {
                $q->whereNull('id_departemen')
                    ->orWhere('id_departemen', 0);
                })
            ->whereIn('id_status_karyawan', [1, 2, 3])
            ->orderBy('tgl_masuk', 'desc')
            ->orderBy('nik')
            ->get()->map( function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $query = PayrollModel::where('id_karyawan', $arr['id'])
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
                $query = PayrollModel::where('id_karyawan', $arr['id'])
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
            'persen_bpjs' => (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan,
            'persen_jht' => (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan,
            'persen_jp' => (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan
        ];
        return view('HRD.penggajian.form_pengaturan', $data);
    }

    public function formTunjangan($id_karyawan, $bulan, $tahun)
    {
        $karyawan = KaryawanModel::find($id_karyawan);
        if($bulan==1) {
            $last_bulan = 12;
            $last_tahun= $tahun - 1;
        } else {
            $last_bulan = $bulan - 1;
            $last_tahun = $tahun;
        }
        $last_payroll = PayrollModel::where('id_karyawan', $id_karyawan)->where('bulan', $last_bulan)->where('tahun', $last_tahun)->first();
        $current_payroll = PayrollModel::where('id_karyawan', $id_karyawan)->where('bulan', $bulan)->where('tahun', $tahun)->first();
        //tunjangan perusahaan
        $res_persen_bpjs = SetupBPJSModel::first();
        $gapok_bpjs = $karyawan->gaji_bpjs;
        $persen_bpjs = (empty($res_persen_bpjs->bpjsks_perusahaan)) ? '0' : $res_persen_bpjs->bpjsks_perusahaan;
        $persen_jht = (empty($res_persen_bpjs->jht_perusahaan)) ? '0' : $res_persen_bpjs->jht_perusahaan;
        $persen_jp = (empty($res_persen_bpjs->jp_perusahaan)) ? '0' : $res_persen_bpjs->jp_perusahaan;
        $persen_jkk = (empty($res_persen_bpjs->jkk_perusahaan)) ? '0' : $res_persen_bpjs->jkk_perusahaan;
        $persen_jkm = (empty($res_persen_bpjs->jkm_perusahaan)) ? '0' : $res_persen_bpjs->jkm_perusahaan;
        //potongan bpjs kesehatan
        $tunj_bpjs_ks = (empty($karyawan->bpjs_kesehatan)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_bpjs);
        $tunj_jht = (empty($karyawan->bpjs_tk_jht)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jht);
        $tunj_jp = (empty($karyawan->bpjs_tk_jp)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jp);
        $tunj_jkk = (empty($karyawan->bpjs_tk_jkk)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jkk);
        $tunj_jkm = (empty($karyawan->bpjs_tk_jkm)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jkm);
        $tot_tunj_bpjs = $tunj_bpjs_ks +$tunj_jht + $tunj_jp + $tunj_jkk + $tunj_jkm;
        //tunjangan tetap
        if(empty($current_payroll->tunj_tetap)) {
            $tunj_tetap = (empty($last_payroll->tunj_tetap)) ? 0 : $last_payroll->tunj_tetap;
        } else {
            $tunj_tetap = $current_payroll->tunj_tetap;
        }
        //meter hours
        $hours_meter = (empty($current_payroll->hours_meter)) ? 0 : $current_payroll->hours_meter;
        //lembur
        $lembur = (empty($current_payroll->lembur)) ? 0 : $current_payroll->lembur;
        //bonus
        $bonus = (empty($current_payroll->bonus)) ? 0 : $current_payroll->bonus;
        //tunjangan perusahaan
        $tunj_perusahaan_bpjs = (empty($last_payroll->pot_tunj_perusahaan)) ? $tot_tunj_bpjs : $current_payroll->pot_tunj_perusahaan;

        $total_tunjangan = $tunj_perusahaan_bpjs + $tunj_tetap + $hours_meter + $lembur + $bonus;
        //draft bruto
        // $gaji_bruto = (empty($current_payroll->gaji_bruto)) ? $draft_bruto : $current_payroll->gaji_bruto;
        $data = [
            'profil' => $karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'payroll' => PayrollModel::where('id_karyawan', $id_karyawan)->where('bulan', $bulan)->where('tahun', $tahun)->first(),
            'last_payroll' => $last_payroll,
            'tunj_perusahaan_bpjs' => $tunj_perusahaan_bpjs,
            'tunj_tetap' => $tunj_tetap,
            'hours_meter' => $hours_meter,
            'lembur' => $lembur,
            'bonus' => $bonus,
            'bpjsks_perusahaan' => $tunj_bpjs_ks,
            'bpjstk_jht_perusahaan' => $tunj_jht,
            'bpjstk_jp_perusahaan' => $tunj_jp,
            'bpjstk_jkk_perusahaan' => $tunj_jkk,
            'bpjstk_jkm_perusahaan' => $tunj_jkm,
            'total_tunjangan' => $total_tunjangan,
        ];
        return view('HRD.penggajian.form_tunjangan', $data);
    }
    //form potongan
    public function formPotongan($id_karyawan, $bulan, $tahun)
    {
        $karyawan = KaryawanModel::find($id_karyawan);
        if($bulan==1) {
            $last_bulan = 12;
            $last_tahun= $tahun - 1;
        } else {
            $last_bulan = $bulan - 1;
            $last_tahun = $tahun;
        }
        $last_payroll = PayrollModel::where('id_karyawan', $id_karyawan)->where('bulan', $last_bulan)->where('tahun', $last_tahun)->first();
        $current_payroll = PayrollModel::where('id_karyawan', $id_karyawan)->where('bulan', $bulan)->where('tahun', $tahun)->first();
        $res_persen_bpjs = SetupBPJSModel::first();
        $gapok = $karyawan->gaji_pokok;
        $gapok_bpjs = $karyawan->gaji_bpjs;
        $persen_bpjs = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
        $persen_jht = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
        $persen_jp = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
        $persen_jkk = (empty($res_persen_bpjs->jkk_karyawan)) ? '0' : $res_persen_bpjs->jkk_karyawan;
        $persen_jkm = (empty($res_persen_bpjs->jkm_karyawan)) ? '0' : $res_persen_bpjs->jkm_karyawan;
        //potongan bpjs kesehatan
        $pot_bpjs_ks = (empty($karyawan->bpjs_kesehatan)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_bpjs);
        $pot_jht = (empty($karyawan->bpjs_tk_jht)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jht);
        $pot_jp = (empty($karyawan->bpjs_tk_jp)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jp);
        $pot_jkk = (empty($karyawan->bpjs_tk_jkk)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jkk);
        $pot_jkm = (empty($karyawan->bpjs_tk_jkm)) ? 0 : Payroll::getPotTunjBpjs($gapok_bpjs, $persen_jkm);
        //potongan sedekah
        if(empty($current_payroll->pot_sedekah)) {
            $pot_sedekah = (empty($last_payroll->pot_sedekah)) ? 0 : $last_payroll->pot_sedekah;
        } else {
            $pot_sedekah = $current_payroll->pot_sedekah;
        }
        //potongan pinjaman karyawan (pkk)
        $pinjaman_karyawan = PinjamanKaryawanModel::where('id_karyawan', $id_karyawan)->where('aktif', 'y');
        if($pinjaman_karyawan->get()->count()==0) {
            $nom_pkk = 0;
        } else {
            $nom_pkk = (empty($pinjaman_karyawan->first()->angsuran)) ? 0 : $pinjaman_karyawan->first()->angsuran;
        }
        if(empty($current_payroll->pot_pkk)) {
            $pot_pkk = $nom_pkk; // (empty($last_payroll->pot_pkk)) ? 0 : $last_payroll->pot_pkk;
        } else {
            $pot_pkk = $current_payroll->pot_pkk;
        }
        //potongan air
        if(empty($current_payroll->pot_air)) {
            $pot_air = (empty($last_payroll->pot_air)) ? 0 : $last_payroll->pot_air;
        } else {
            $pot_air = $current_payroll->pot_air;
        }
        //potongan rumah
        if(empty($current_payroll->pot_rumah)) {
            $pot_rumah = (empty($last_payroll->pot_rumah)) ? 0 : $last_payroll->pot_rumah;
        } else {
            $pot_rumah = $current_payroll->pot_rumah;
        }
        //potongan toko alif
        if(empty($current_payroll->pot_toko_alif)) {
            $pot_toko_alif = (empty($last_payroll->pot_toko_alif)) ? 0 : $last_payroll->pot_toko_alif;
        } else {
            $pot_toko_alif = $current_payroll->pot_toko_alif;
        }

        $data = [
            'profil' => $karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'bpjsks_karyawan' => $pot_bpjs_ks,
            'bpjstk_jht_karyawan' => $pot_jht,
            'bpjstk_jp_karyawan' => $pot_jp,
            'bpjstk_jkk_karyawan' => $pot_jkk,
            'bpjstk_jkm_karyawan' => $pot_jkm,
            'pot_sedekah' => $pot_sedekah,
            'pot_pkk' => $pot_pkk,
            'pot_air' => $pot_air,
            'pot_rumah' => $pot_rumah,
            'pot_toko_alif' => $pot_toko_alif
        ];
        return view('HRD.penggajian.form_potongan', $data);
    }

    //detail tunjangan
    public function detailTunjangan($id, $bulan, $tahun)
    {
        $karyawan = KaryawanModel::find($id);
        $gapok = $karyawan->gaji_pokok;
        $data = [
            'profil' => $karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'payroll' => PayrollModel::where('id_karyawan', $id)->where('bulan', $bulan)->where('tahun', $tahun)->first()
        ];
        return view('HRD.penggajian.detail_tunjangan', $data);
    }

    //detail potongan
    public function detailPotongan($id, $bulan, $tahun)
    {
        $karyawan = KaryawanModel::find($id);
        $data = [
            'profil' => $karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun,
            'payroll' => PayrollModel::where('id_karyawan', $id)->where('bulan', $bulan)->where('tahun', $tahun)->first(),
        ];
        return view('HRD.penggajian.detail_potongan', $data);
    }

    public function simpanPenggajianTunjangan(Request $request)
    {
        $checkPayroll = PayrollModel::where('id_karyawan', $request->id_karyawan)
                            ->where('bulan', $request->periode_bulan)
                            ->where('tahun', $request->periode_tahun);
        if($checkPayroll->get()->count() == 0)
        {
            PayrollModel::create([
                "id_karyawan"=> $request->id_karyawan,
                "id_departemen" => $request->id_departemen,
                "bulan" => $request->periode_bulan,
                "tahun" => $request->periode_tahun,
                "gaji_pokok" => $request->gaji_pokok,
                "gaji_bpjs" => $request->gaji_bpjs,
                "tunj_perusahaan" => str_replace(",","", $request->inpTotalTunjangan),
                "tunj_tetap" => str_replace(",","", $request->inpTunjTetap),
                "hours_meter" => str_replace(",","", $request->inpTunjHoursMeter),
                "lembur" => str_replace(",","", $request->inpTunjLembur),
                "bonus" => str_replace(",","", $request->inpTunjBonus),
                "bpjsks_perusahaan" => str_replace(",","", $request->inpTunjBpjsKesehatan),
                "bpjstk_jht_perusahaan" => str_replace(",","", $request->inpTunjJht),
                "bpjstk_jp_perusahaan" => str_replace(",","", $request->inpTunjJp),
                "bpjstk_jkm_perusahaan" => str_replace(",","", $request->inpTunjJKM),
                "bpjstk_jkk_perusahaan" => str_replace(",","", $request->inpTunjJkk),
                // "gaji_bruto" => str_replace(",","", $request->inpGajiBruto),
                "pot_tunj_perusahaan" => str_replace(",","", $request->inpTunjPerusahaanBPJS),
                "cetak_slip" => 0 //belum pernah cetak slip berdasarkan periode penggajian
            ]);
        } else {
            $dataPayroll = $checkPayroll->first();
            $update = PayrollModel::find($dataPayroll->id);
            $update->tunj_perusahaan = str_replace(",","", $request->inpTotalTunjangan);
            $update->tunj_tetap = str_replace(",","", $request->inpTunjTetap);
            $update->hours_meter = str_replace(",","", $request->inpTunjHoursMeter);
            $update->lembur = str_replace(",","", $request->inpTunjLembur);
            $update->bonus = str_replace(",","", $request->inpTunjBonus);
            $update->bpjsks_perusahaan = str_replace(",","", $request->inpTunjBpjsKesehatan);
            $update->bpjstk_jht_perusahaan = str_replace(",","", $request->inpTunjJht);
            $update->bpjstk_jp_perusahaan = str_replace(",","", $request->inpTunjJp);
            $update->bpjstk_jkm_perusahaan = str_replace(",","", $request->inpTunjJKM);
            $update->bpjstk_jkk_perusahaan = str_replace(",","", $request->inpTunjJkk);
            // $update->gaji_bruto = str_replace(",","", $request->inpGajiBruto);
            $update->pot_tunj_perusahaan = str_replace(",","", $request->inpTunjPerusahaanBPJS);
            $update->save();
        }
        $this->update_thp($request->id_karyawan, $request->periode_bulan, $request->periode_tahun);
        return redirect('hrd/penggajian/pengaturanPenggajian/'.$request->id_departemen."/".$request->periode_bulan."/".$request->periode_tahun)->with('konfirm', 'Data berhasil disimpan');
    }

    public function simpanPenggajianPotongan(Request $request)
    {
        $karyawan = KaryawanModel::find($request->id_karyawan);
        $res_persen_bpjs = SetupBPJSModel::first();
        $persen_bpjsks_karyawan = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
        $persen_jkm_karyawan = (empty($res_persen_bpjs->jkm_karyawan)) ? '0' : $res_persen_bpjs->jkm_karyawan;
        $persen_jkk_karyawan = (empty($res_persen_bpjs->jkk_karyawan)) ? '0' : $res_persen_bpjs->jkk_karyawan;
        $persen_jht_karyawan = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
        $persen_jp_karyawan = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
        //perusahaan
        $persen_bpjsks_perus = (empty($res_persen_bpjs->bpjsks_perusahaan)) ? '0' : $res_persen_bpjs->bpjsks_perusahaan;
        $persen_jht_perus = (empty($res_persen_bpjs->jht_perusahaan)) ? '0' : $res_persen_bpjs->jht_perusahaan;
        $persen_jkk_perus = (empty($res_persen_bpjs->jkk_perusahaan)) ? '0' : $res_persen_bpjs->jkk_perusahaan;
        $persen_jkm_perus = (empty($res_persen_bpjs->jkm_perusahaan)) ? '0' : $res_persen_bpjs->jkm_perusahaan;
        $persen_jp_perus = (empty($res_persen_bpjs->jp_perusahaan)) ? '0' : $res_persen_bpjs->jp_perusahaan;
        $gaji_bpjs = $request->gaji_bpjs;
        $gapok = $request->gaji_pokok;

        $pot_bpjsks_karyawan = (empty($karyawan->bpjs_kesehatan)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_bpjsks_karyawan);
        $pot_jkm_karyawan = (empty($karyawan->bpjs_tk_jkm)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jkm_karyawan);
        $pot_jkk_karyawan = (empty($karyawan->bpjs_tk_jkk)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jkk_karyawan);
        $pot_jht_karyawan = (empty($karyawan->bpjs_tk_jht)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jht_karyawan);
        $pot_jp_karyawan = (empty($karyawan->bpjs_tk_jp)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jp_karyawan);

        $tunj_bpjsks_perusahaan = (empty($karyawan->bpjs_kesehatan)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_bpjsks_perus);
        $tunj_jkm_perusahaan = (empty($karyawan->bpjs_tk_jkm)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jkm_perus);
        $tunj_jkk_perusahaan = (empty($karyawan->bpjs_tk_jkk)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jkk_perus);
        $tunj_jht_perusahaan = (empty($karyawan->bpjs_tk_jht)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jht_perus);
        $tunj_jp_perusahaan = (empty($karyawan->bpjs_tk_jp)) ? 0 : Payroll::getPotTunjBpjs($gaji_bpjs, $persen_jp_perus);
        $checkPayroll = PayrollModel::where('id_karyawan', $request->id_karyawan)
                            ->where('bulan', $request->periode_bulan)
                            ->where('tahun', $request->periode_tahun)
                            ->get()->count();
        if($checkPayroll == 0)
        {
            PayrollModel::create([
                "id_karyawan"=> $request->id_karyawan,
                "id_departemen" => $request->id_departemen,
                "bulan" => $request->periode_bulan,
                "tahun" => $request->periode_tahun,
                "gaji_pokok" => $request->gaji_pokok,
                "gaji_bpjs" => $request->gaji_bpjs,
                "gaji_jamsostek" => $request->gaji_jamsostek,
                "bpjsks_karyawan" => $pot_bpjsks_karyawan,
                "bpjstk_jht_karyawan" => $pot_jht_karyawan,
                "bpjstk_jp_karyawan" => $pot_jp_karyawan,
                "bpjstk_jkm_karyawan" => $pot_jkm_karyawan,
                "bpjstk_jkk_karyawan" => $pot_jkk_karyawan,
                "bpjsks_perusahaan" => $tunj_bpjsks_perusahaan,
                "bpjstk_jht_perusahaan" => $tunj_jht_perusahaan,
                "bpjstk_jp_perusahaan" => $tunj_jp_perusahaan,
                "bpjstk_jkm_perusahaan" => $tunj_jkm_perusahaan,
                "bpjstk_jkk_perusahaan" => $tunj_jkk_perusahaan,
                "pot_sedekah" => str_replace(",","", $request->inpPotSedekah),
                "pot_pkk" => str_replace(",","", $request->inpPotPkk),
                "pot_air" => str_replace(",","", $request->inpPotAir),
                "pot_rumah" => str_replace(",","", $request->inpPotRumah),
                "pot_toko_alif" => str_replace(",","", $request->inpPotTokoAlif),
                "cetak_slip" => 0 //belum pernah cetak slip berdasarkan periode penggajian
            ]);
        } else {
            $dataPayroll = PayrollModel::select([
                            'id'
                            ])
                            ->where('id_karyawan', $request->id_karyawan)
                            ->where('bulan', $request->periode_bulan)
                            ->where('tahun', $request->periode_tahun)
                            ->first();
            $update = PayrollModel::find($dataPayroll->id);
            $update->bpjsks_karyawan = $pot_bpjsks_karyawan;
            $update->bpjstk_jht_karyawan = $pot_jht_karyawan;
            $update->bpjstk_jp_karyawan = $pot_jp_karyawan;
            $update->bpjstk_jkm_karyawan = $pot_jkm_karyawan;
            $update->bpjstk_jkk_karyawan = $pot_jkk_karyawan;
            $update->bpjsks_perusahaan = $tunj_bpjsks_perusahaan;
            $update->bpjstk_jht_perusahaan = $tunj_jht_perusahaan;
            $update->bpjstk_jp_perusahaan = $tunj_jp_perusahaan;
            $update->bpjstk_jkm_perusahaan = $tunj_jkm_perusahaan;
            $update->bpjstk_jkk_perusahaan = $tunj_jkk_perusahaan;
            $update->pot_sedekah = str_replace(",","", $request->inpPotSedekah);
            $update->pot_pkk = str_replace(",","", $request->inpPotPkk);
            $update->pot_air = str_replace(",","", $request->inpPotAir);
            $update->pot_rumah = str_replace(",","", $request->inpPotRumah);
            $update->pot_toko_alif = str_replace(",","", $request->inpPotTokoAlif);
            $update->save();
        }
        $this->update_thp($request->id_karyawan, $request->periode_bulan, $request->periode_tahun);
        return redirect('hrd/penggajian/pengaturanPenggajian/'.$request->id_departemen."/".$request->periode_bulan."/".$request->periode_tahun)->with('konfirm', 'Data berhasil disimpan');
    }

    public function update_thp($id_karyawan, $bulan, $tahun)
    {
        $checkPayroll = PayrollModel::where('id_karyawan', $id_karyawan)
                            ->where('bulan', $bulan)
                            ->where('tahun', $tahun)->first();
        $gapok = $checkPayroll->gaji_pokok;
        //potongan
        $pot_bpjs_ks = $checkPayroll->bpjsks_karyawan;
        $pot_jht = $checkPayroll->bpjstk_jht_karyawan;
        $pot_jp = $checkPayroll->bpjstk_jp_karyawan;
        $pot_sedekah = $checkPayroll->pot_sedekah;
        $pot_pkk = $checkPayroll->pot_pkk;
        $pot_air = $checkPayroll->pot_air;
        $pot_rumah = $checkPayroll->pot_rumah;
        $pot_toko_alif = $checkPayroll->pot_toko_alif;
        $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
        //tunjangan
        $total_tunj_perusahaan_bpjs = $checkPayroll->pot_tunj_perusahaan;
        $total_tunj_perusahaan = $checkPayroll->tunj_perusahaan;
        $gaji_bruto = $gapok + $total_tunj_perusahaan;
        //thp
        $thp = $gaji_bruto - $total_tunj_perusahaan_bpjs - $tot_potongan;
        $update = PayrollModel::find($checkPayroll->id);
        $update->thp = $thp;
        $update->save();
    }

    //list gaji - approval
    public function getDataPenggajianAll(Request $request) {
        $columns = ['created_at'];
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $totalData = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get()->count();
        $search = $request->input('search.value');
        $query = KaryawanModel::with([
            'get_jabatan'
        ])
        ->whereIn('id_status_karyawan', [1, 2, 3]);

        if($request->input('dept') != null) {
            if($request->input('dept')=="0") {
                $query->where(function ($q) {
                $q->whereNull('id_departemen')
                    ->orWhere('id_departemen', 0);
                });
            } else {
                $query->where('id_departemen', $request->input('dept'));
            }
            // dd($request->input('dept'));
        }
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
        ->orderBy('id_departemen')
        ->orderBy('nik')
        ->orderBy('tgl_masuk', 'desc')
        ->get()->map( function ($row) use ($bulan, $tahun) {
            $arr = $row->toArray();
            $query = PayrollModel::where('id_karyawan', $arr['id'])
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
        // dd($query);
        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            $ket_status = "";
            $res_persen_bpjs = SetupBPJSModel::first();
            $persen_bpjs = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
            $persen_jht = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
            $persen_jp = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
            foreach($query as $r){
                $tunj_perusahaan = 0;
                $tunj_tetap = 0;
                $hours_meter = 0;
                $lembur = 0;
                $tot_tunjangan = 0;
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

                $list_status = FacadesConfig::get('constants.status_karyawan');
                foreach($list_status as $key => $value)
                {
                    if($key==$r['id_status_karyawan'])
                    {
                        $ket_status = $value;
                        break;
                    }
                }
                $status = "<span class='".$badge_thema."'>".$ket_status."</span>";

                // $status = "<span class='badge iq-bg-danger'>".$ket_status."</span>";
                if($r['payrol']==null)
                {
                    $gapok = 0;
                    $tot_potongan = 0;
                    $thp = 0;
                } else {
                    $gapok = $r['payrol']['gaji_pokok'];
                    //potongan
                    $pot_bpjs_ks = (empty($r['payrol']['bpjsks_karyawan'])) ? 0 : $r['payrol']['bpjsks_karyawan'];
                    $pot_jht = (empty($r['payrol']['bpjstk_jht_karyawan'])) ? 0 : $r['payrol']['bpjstk_jht_karyawan'];
                    $pot_jp = (empty($r['payrol']['bpjstk_jp_karyawan'])) ? 0 : $r['payrol']['bpjstk_jp_karyawan'];
                    $pot_sedekah = $r['payrol']['pot_sedekah'];
                    $pot_pkk = $r['payrol']['pot_pkk'];
                    $pot_air = $r['payrol']['pot_air'];
                    $pot_rumah = $r['payrol']['pot_rumah'];
                    $pot_toko_alif = $r['payrol']['pot_toko_alif'];
                    $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                    //tunjangan
                    $tunj_perusahaan = $r['payrol']['tunj_perusahaan'];
                    $tunj_tetap = $r['payrol']['tunj_tetap'];
                    $hours_meter = $r['payrol']['hours_meter'];
                    $lembur = $r['payrol']['lembur'];
                    $tot_tunjangan = $tunj_perusahaan + $tunj_tetap + $hours_meter + $lembur;
                    //thp
                    $thp = ($gapok + $tot_tunjangan) - $tot_potongan;
                }
                $act_tunjangan = "";
                $act_potongan = "";
                if(!empty($r['gaji_pokok']))
                {
                    $act_tunjangan = '<div class="btn-group mb-1 dropup">
                    <button type="button" class="btn btn-success">'.number_format($tot_tunjangan, 0).'</button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Aksi</span>
                    </button>
                    <div class="dropdown-menu">
                       <a class="dropdown-item" data-toggle="modal" data-target="#ModalFormDetail" onclick="detailTunjangan(this)" id="'. $r['id'].'">Detail</a>
                    </div>
                </div>';
                }
                if(!empty($r['gaji_pokok']))
                {
                    $act_potongan = '<div class="btn-group mb-1 dropup">
                    <button type="button" class="btn btn-danger">'.number_format($tot_potongan, 0).'</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Aksi</span>
                    </button>
                    <div class="dropdown-menu">
                       <a class="dropdown-item" data-toggle="modal" data-target="#ModalFormDetail" onclick="detailPotongan(this)" id="'. $r['id'].'">Detail</a>
                    </div>
                </div>';
                }

                $Data['no'] = $counter;
                $Data['karyawan'] = $r['nik']." - ".$r['nm_lengkap'];
                $Data['posisi'] = (!empty($r['id_jabatan']) ? $r['get_jabatan']['nm_jabatan'] : "");
                $Data['status'] = $status;
                $Data['gapok'] = number_format($r['gaji_pokok'], 0);
                $Data['tunjangan'] = $act_tunjangan;
                $Data['potongan'] = $act_potongan;
                $Data['thp'] = number_format($thp, 0);
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

    public function simpan_penggajian(Request $request)
    {
        $res_persen_bpjs = SetupBPJSModel::first();
        $persen_jkm_karyawan = (empty($res_persen_bpjs->jkm_karyawan)) ? '0' : $res_persen_bpjs->jkm_karyawan;
        $persen_jkk_karyawan = (empty($res_persen_bpjs->jkk_karyawan)) ? '0' : $res_persen_bpjs->jkk_karyawan;
        //perusahaan
        $persen_bpjsks_perus = (empty($res_persen_bpjs->bpjsks_perusahaan)) ? '0' : $res_persen_bpjs->bpjsks_perusahaan;
        $persen_jht_perus = (empty($res_persen_bpjs->jht_perusahaan)) ? '0' : $res_persen_bpjs->jht_perusahaan;
        $persen_jkk_perus = (empty($res_persen_bpjs->jkk_perusahaan)) ? '0' : $res_persen_bpjs->jkk_perusahaan;
        $persen_jkm_perus = (empty($res_persen_bpjs->jkm_perusahaan)) ? '0' : $res_persen_bpjs->jkm_perusahaan;
        $persen_jp_perus = (empty($res_persen_bpjs->jp_perusahaan)) ? '0' : $res_persen_bpjs->jp_perusahaan;
        $id_dept = $request->pil_departemen;
        $bulan = $request->pil_periode_bulan;
        $tahun = $request->inp_periode_tahun;
        $jml_baris = count($request->id_karyawan);
        foreach(array($request) as $key => $value)
        {
            for($i=0; $i<$jml_baris; $i++) {
                $id_karyawan = $value['id_karyawan'][$i];
                $gaji_bpjs = KaryawanModel::find($id_karyawan)->first()->gaji_bpjs;
                $gaji_jamsostek = KaryawanModel::find($id_karyawan)->first()->gaji_jamsostek;
                $gapok = str_replace(",","", $value['inp_gapok'][$i]);
                $nom_jkm_karyawan = ($gaji_bpjs * $persen_jkm_karyawan) / 100;
                $nom_jkk_karyawan = ($gaji_bpjs * $persen_jkk_karyawan) / 100;
                $nom_bpjsks_perus = ($gaji_bpjs * $persen_bpjsks_perus) / 100;
                $nom_jht_perus = ($gaji_bpjs * $persen_jht_perus) / 100;
                $nom_jkk_perus = ($gaji_bpjs * $persen_jkk_perus) / 100;
                $nom_jkm_perus = ($gaji_bpjs * $persen_jkm_perus) / 100;
                $nom_jp_perus = ($gaji_bpjs * $persen_jp_perus) / 100;
                $cek_data = PayrollModel::where("id_karyawan", $id_karyawan)->where("bulan", $bulan)->where("tahun", $tahun)->get();
                if(count($cek_data)==0){
                    PayrollModel::create([
                        "id_karyawan"=>$id_karyawan,
                        "id_departemen" => $id_dept,
                        "bulan" => $bulan,
                        "tahun" => $tahun,
                        "gaji_pokok" => str_replace(",","", $value['inp_gapok'][$i]),
                        "gaji_bpjs" => $gaji_bpjs,
                        "gaji_jamsostek" => $gaji_jamsostek,
                        "tunj_perusahaan" => str_replace(",","", $value['inp_tunj_perus'][$i]),
                        "tunj_tetap" => str_replace(",","", $value['inp_tunj_tetap'][$i]),
                        "hours_meter" => str_replace(",","", $value['inp_tunj_hours'][$i]),
                        "lembur" => str_replace(",","", $value['inp_tunj_lembur'][$i]),
                        "bpjsks_karyawan" => str_replace(",","", $value['inp_bpjs_ks'][$i]),
                        "bpjstk_jht_karyawan" => str_replace(",","", $value['inp_jht_karyawan'][$i]),
                        "bpjstk_jp_karyawan" => str_replace(",","", $value['inp_jp_karyawan'][$i]),
                        "bpjstk_jkm_karyawan" => $nom_jkm_karyawan,
                        "bpjstk_jkk_karyawan" => $nom_jkk_karyawan,
                        "bpjsks_perusahaan" => $nom_bpjsks_perus,
                        "bpjstk_jht_perusahaan" => $nom_jht_perus,
                        "bpjstk_jp_perusahaan" => $nom_jp_perus,
                        "bpjstk_jkm_perusahaan" => $nom_jkm_perus,
                        "bpjstk_jkk_perusahaan" => $nom_jkk_perus,
                        "cetak_slip" => 0 //belum pernah cetak slip berdasarkan periode penggajian
                    ]);
                }
            }
        }
        return redirect('hrd/penggajian')->with('konfirm', 'Data berhasil disimpan');
    }
    public function create_slipgaji()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_karyawan'] = KaryawanModel::with('get_jabatan', 'get_departemen')
            ->whereIn('id_status_karyawan', [1, 2, 3])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.penggajian.slipgaji.index', $data);
    }
    public function list_gaji_karyawan($key)
    {
        $result = \DB::table('hrd_payroll')
                    ->join('hrd_karyawan', 'hrd_payroll.id_karyawan', '=', 'hrd_karyawan.id')
                    ->where('hrd_karyawan.id', $key)
                    ->where('hrd_payroll.flag', 1)
                    ->select('hrd_payroll.id', 'hrd_payroll.id_karyawan', 'hrd_karyawan.nik', 'hrd_karyawan.nm_lengkap', 'hrd_payroll.bulan', 'hrd_payroll.tahun', 'hrd_payroll.gaji_pokok', 'hrd_payroll.bpjsks_karyawan', 'hrd_payroll.bpjstk_jht_karyawan', 'hrd_payroll.bpjstk_jp_karyawan')
                    ->get();
        if($result)
        {
           $respon = '<table class="table" style="width: 100%">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Periode</th>
                            <th style="width: 15%">NIK</th>
                            <th>Nama Karyawan</th>
                            <th style="width: 25%; text-align:right">THP</th>
                            <th style="width: 10%">Action</th>
                        </tr>';
                $nom=1;
                foreach($result as $key => $value)
                {   $tot_pot = doubleval($value->bpjsks_karyawan) + doubleval($value->bpjstk_jht_karyawan) + doubleval($value->bpjstk_jp_karyawan);
                    $thp = doubleval($value->gaji_pokok) - doubleval($tot_pot);
                    $respon .= '<tr>
                                <td>'.$nom.'</td>
                                <td>'.\App\Helpers\Hrdhelper::get_nama_bulan($value->bulan).' '.$value->tahun.'</td>
                                <td>'.$value->nik.'</td>
                                <td>'.$value->nm_lengkap.'</td>
                                <td style="text-align:right">Rp. '.number_format($thp, 0).'</td>
                                <td><a href='.url('hrd/penggajian/slipgaji_print_slip/'.\App\Helpers\Hrdhelper::encrypt_decrypt('encrypt', $value->id)).' target="_new" class="btn btn-success"><i class="fa fa-print"></i></a></td>
                                </tr>';
                $nom++;
                }
            $respon .='</table>';
        } else {
            $respon = "<div style='text-align:center'><b>NIK tidak ditemukan</b></div>";
        }
        echo $respon;
    }
    public function print_gaji_karyawan($id)
    {
        $id_data = \App\Helpers\Hrdhelper::encrypt_decrypt('decrypt', $id);
        $result = PayrollModel::with(['get_profil'])->find($id_data);
        $kop_surat = \App\Helpers\Hrdhelper::get_kop_surat();
        $res_potongan = PotonganGajiKaryawanModel::with('get_item_potongan')->where('id_karyawan', $result->id_karyawan)->get();
        $pdf = PDF::loadview('HRD.penggajian.slipgaji.print', compact('result', 'res_potongan', 'kop_surat'))->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    //Approval Penggajian
    public function persetujuan()
    {
        $data['result_payroll'] = PayrollModel::select('bulan', 'tahun')
            ->whereNull('flag')
            ->selectRaw('sum(gaji_pokok) as total_gapok')
            ->selectRaw('sum(tunj_perusahaan + tunj_tetap + hours_meter) as total_tunjangan')
            ->groupBy('bulan', 'tahun')
            ->orderBy('bulan', 'asc')
            ->get();
        $data['role_user'] = $user = auth()->user();
        return view('HRD.penggajian.persetujuan.index', $data);
    }

    public function detail_penggajian($bulan, $tahun)
    {
        $data['periode'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan)." ".$tahun;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['list_data'] = PayrollModel::where('bulan', $bulan)->where('tahun', $tahun)->orderby('id_karyawan', 'asc')->get();
        return view('HRD.penggajian.persetujuan.detail', $data);
    }

    public function persetujuan_store(Request $request)
    {
        PayrollModel::where('bulan', $request->periode_bulan)
            ->where('tahun', $request->periode_tahun)
            ->update([
                'flag' => 1,
                'appr_date' =>  date('Y-m-d H:i:s'),
                'appr_by' =>auth()->user()->id
            ]);
        return redirect('hrd/penggajian/persetujuan')->with('konfirm', 'Proses persetujuan Penggajian berhasil disimpan');
    }

    //tools
    public function templatePeriodePenggajian($tahun, $bulan)
    {
        return Excel::download(new PenggajianTemplate($tahun, $bulan), 'templatePeriodePenggajianKaryawan.xlsx');
    }

    public function formImportPeriodePenggajian()
    {
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view("HRD.penggajian.tools.formImport");
    }

    public function doImportPeriodePenggajian(Request $request)
    {
        try {
            if (!$request->hasFile('file_imp')) {
                return back()->withStatus('Gagal Import: File tidak ditemukan atau ukuran file melebihi batas sistem.');
            }

            $file = $request->file('file_imp');
            if (!$file->isValid()) {
                return back()->withStatus('Gagal Import: ' . $file->getErrorMessage());
            }

            // Store file temporarily using direct move
            $fileName = 'import_' . time() . '_' . $file->getClientOriginalName();
            $tempPath = storage_path('app/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            $file->move($tempPath, $fileName);
            $fullPath = $tempPath . DIRECTORY_SEPARATOR . $fileName;

            if (!file_exists($fullPath)) {
                return back()->withStatus('Gagal Import: File gagal dipindahkan ke direktori sementara.');
            }

            Excel::import(new PeriodePenggajianImport, $fullPath);

            // Clean up
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return back()->withStatus('Excel file import succesfully');
        } catch (\Exception $ex) {
            Log::error('Import error: ' . $ex->getMessage());
            return back()->withStatus('Error during import: ' . $ex->getMessage());
        }
    }

    /**
     * Preview Excel file and return parsed data with validation
     * Used for payroll import preview functionality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function previewImportPeriodePenggajian(Request $request)
    {
        try {
            // Validate file upload
            $request->validate([
                'file_imp' => 'required|file|mimes:csv,xlsx|max:10240' // 10MB max
            ]);

            $file = $request->file('file_imp');

            // Parse Excel file
            $importer = new PeriodePenggajianImport();
            $parsedData = $importer->parseForPreview($file);

            // Validate parsed data
            $validator = new PayrollImportValidator();
            $validationResults = $validator->validate($parsedData);

            // Calculate summary counts
            $summary = [
                'total_rows' => $parsedData->count(),
                'valid_rows' => count($validationResults['valid']),
                'error_rows' => count($validationResults['errors']),
                'warning_rows' => count($validationResults['warnings'])
            ];

            // Store parsed data and validation results in session
            $sessionKey = 'payroll_import_preview_' . auth()->id() . '_' . time();
            session([
                $sessionKey => [
                    'parsed_data' => $parsedData->toArray(),
                    'validation_results' => $validationResults,
                    'summary' => $summary,
                    'created_at' => now()->toDateTimeString()
                ]
            ]);

            // Store session key for later retrieval
            session(['payroll_import_session_key' => $sessionKey]);

            return response()->json([
                'success' => true,
                'data' => [
                    'rows' => $parsedData->toArray(),
                    'validation' => $validationResults['all'],
                    'summary' => $summary,
                    'session_key' => $sessionKey
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'File validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Preview import failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to parse Excel file: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Confirm and execute the import from session data
     * Used for payroll import confirmation functionality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmImportPeriodePenggajian(Request $request)
    {
        try {
            // Retrieve session key
            $sessionKey = session('payroll_import_session_key');

            // Check if session data exists
            if (!$sessionKey || !session()->has($sessionKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preview data not found. Please upload the file again.'
                ], 400);
            }

            // Retrieve parsed data from session
            $sessionData = session($sessionKey);
            $parsedData = collect($sessionData['parsed_data']);

            // Re-validate data as security check
            $validator = new PayrollImportValidator();
            $validationResults = $validator->validate($parsedData);

            // Initialize counters
            $importedCount = 0;
            $skippedDuplicates = 0;

            // Wrap database operations in transaction
            DB::beginTransaction();

            try {
                // Insert only valid rows (skip duplicates and error rows)
                foreach ($parsedData as $index => $row) {
                    // Check validation status for this row from the indexed array
                    $rowValidationStatus = $validationResults['all'][$index]['status'] ?? 'error';

                    // Skip error rows
                    if ($rowValidationStatus === 'error') {
                        continue;
                    }

                    // Check if duplicate
                    $isDuplicate = PayrollModel::where('id_karyawan', $row['id_karyawan'])
                        ->where('bulan', $row['bulan'])
                        ->where('tahun', $row['tahun'])
                        ->exists();

                    if ($isDuplicate) {
                        $skippedDuplicates++;
                        continue;
                    }

                    // Insert valid row
                    $data = [
                        "id_karyawan" => $row["id_karyawan"],
                        "id_departemen" => $row["id_departemen"],
                        "bulan" => $row["bulan"],
                        "tahun" => $row["tahun"],
                        "gaji_pokok" => (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'],
                        "gaji_bpjs" => (empty($row['gaji_bpjs'])) ? 0 : $row['gaji_bpjs'],
                        "tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "tunj_tetap" => (empty($row['tunj_tetap'])) ? 0 : $row['tunj_tetap'],
                        "hours_meter" => (empty($row['hours_meter'])) ? 0 : $row['hours_meter'],
   "lembur" => (empty($row['lembur'])) ? 0 : $row['lembur'],
                        "bonus" => (empty($row['bonus'])) ? 0 : $row['bonus'],
                        "bpjsks_perusahaan" => (empty($row['bpjsks_perusahaan'])) ? 0 : $row['bpjsks_perusahaan'],
                        "bpjstk_jht_perusahaan" => (empty($row['bpjstk_jht_perusahaan'])) ? 0 : $row['bpjstk_jht_perusahaan'],
                        "bpjstk_jp_perusahaan" => (empty($row['bpjstk_jp_perusahaan'])) ? 0 : $row['bpjstk_jp_perusahaan'],
                        "bpjstk_jkm_perusahaan" => (empty($row['bpjstk_jkm_perusahaan'])) ? 0 : $row['bpjstk_jkm_perusahaan'],
                        "bpjstk_jkk_perusahaan" => (empty($row['bpjstk_jkk_perusahaan'])) ? 0 : $row['bpjstk_jkk_perusahaan'],
                        "gaji_bruto" => (empty($row['gaji_bruto'])) ? 0 : $row['gaji_bruto'],
                        "bpjsks_karyawan" => (empty($row['bpjsks_karyawan'])) ? 0 : $row['bpjsks_karyawan'],
                        "bpjstk_jht_karyawan" => (empty($row['bpjstk_jht_karyawan'])) ? 0 : $row['bpjstk_jht_karyawan'],
                        "bpjstk_jp_karyawan" => (empty($row['bpjstk_jp_karyawan'])) ? 0 : $row['bpjstk_jp_karyawan'],
                        "bpjstk_jkm_karyawan" => (empty($row['bpjstk_jkm_karyawan'])) ? 0 : $row['bpjstk_jkm_karyawan'],
                        "bpjstk_jkk_karyawan" => (empty($row['bpjstk_jkk_karyawan'])) ? 0 : $row['bpjstk_jkk_karyawan'],
                        "pot_sedekah" => (empty($row['pot_sedekah'])) ? 0 : $row['pot_sedekah'],
                        "pot_pkk" => (empty($row['pot_pkk'])) ? 0 : $row['pot_pkk'],
                        "pot_air" => (empty($row['pot_air'])) ? 0 : $row['pot_air'],
                        "pot_rumah" => (empty($row['pot_rumah'])) ? 0 : $row['pot_rumah'],
                        "pot_toko_alif" => (empty($row['pot_toko_alif'])) ? 0 : $row['pot_toko_alif'],
                        "pot_tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "thp" => (empty($row['thp'])) ? 0 : $row['thp'],
                        "created_at" => now(),
                        "updated_at" => now(),
                        'cetak_slip' => 0
                    ];

                    PayrollModel::insert($data);
                    $importedCount++;
                }

                // Commit transaction
                DB::commit();

                // Clear session data after successful import
                session()->forget($sessionKey);
                session()->forget('payroll_import_session_key');

                return response()->json([
                    'success' => true,
                    'message' => 'Import completed successfully',
                    'data' => [
                        'imported_rows' => $importedCount,
                        'skipped_duplicates' => $skippedDuplicates,
                        'total_processed' => $importedCount + $skippedDuplicates
                    ]
                ]);

            } catch (\Exception $e) {
                // Rollback on database errors
                DB::rollBack();
                Log::error('Import transaction failed: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Import failed due to database error. Please try again.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Confirm import failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel import preview and clear session data
     * Used for payroll import cancellation functionality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelImportPreview(Request $request)
    {
        try {
            // Retrieve session key
            $sessionKey = session('payroll_import_session_key');

            // Clear session data
            if ($sessionKey) {
                session()->forget($sessionKey);
            }
            session()->forget('payroll_import_session_key');

            return response()->json([
                'success' => true,
                'message' => 'Preview cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel preview failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel preview: ' . $e->getMessage()
            ], 500);
        }
    }

    //submit to approve
    public function submitPenggajian($bulan, $tahun, $uuid)
    {
        $resNonDepartemen = KaryawanModel::with(['get_jabatan'])->whereNull('id_departemen')->where('nik', '<>', '999999999')->get()
            ->map(function ($row) use ($bulan, $tahun) {
                $arr = $row->toArray();
                $id_karyawan = $arr['id'];
                $payrollData = PayrollModel::where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->where('id_karyawan', $id_karyawan)
                    ->first();
                // $list_data = $payrollData;
                // dd($list_data);
                $arr['list_data'] = [
                    'id_karyawan' => $id_karyawan,
                    'gaji_pokok' => $payrollData->gaji_pokok ?? 0,
                    'gaji_bpjs' => $payrollData->gaji_bpjs ?? 0,
                    'tunj_perusahaan' => $payrollData->tunj_perusahaan ?? 0,
                    'tunj_tetap' => $payrollData->tunj_tetap ?? 0,
                    'hours_meter' => $payrollData->hours_meter ?? 0,
                    'pot_tunj_perusahaan' => $payrollData->pot_tunj_perusahaan ?? 0,
                    'bpjsks_karyawan' => $payrollData->bpjsks_karyawan ?? 0,
                    'bpjstk_jht_karyawan' => $payrollData->bpjstk_jht_karyawan ?? 0,
                    'bpjstk_jp_karyawan' => $payrollData->bpjstk_jp_karyawan ?? 0,
                    'bpjstk_jkm_karyawan' => $payrollData->bpjstk_jkm_karyawan ?? 0,
                    'bpjstk_jkk_karyawan' => $payrollData->bpjstk_jkk_karyawan ?? 0,
                    'bpjsks_perusahaan' => $payrollData->bpjsks_perusahaan ?? 0,
                    'bpjstk_jht_perusahaan' => $payrollData->bpjstk_jht_perusahaan ?? 0,
                    'bpjstk_jp_perusahaan' => $payrollData->bpjstk_jp_perusahaan ?? 0,
                    'bpjstk_jkm_perusahaan' => $payrollData->bpjstk_jkm_perusahaan ?? 0,
                    'bpjstk_jkk_perusahaan' => $payrollData->bpjstk_jkk_perusahaan ?? 0,
                    'lembur' => $payrollData->lembur ?? 0,
                    'pot_sedekah' => $payrollData->pot_sedekah ?? 0,
                    'pot_pkk' => $payrollData->pot_pkk ?? 0,
                    'pot_air' => $payrollData->pot_air ?? 0,
                    'pot_rumah' => $payrollData->pot_rumah ?? 0,
                    'pot_toko_alif' => $payrollData->pot_toko_alif ?? 0,
                    'status_payroll' => $payrollData ? 'Terdaftar' : 'Belum Terdaftar',
                    // Tambahkan data lain sesuai kebutuhan
                ];
                return $arr;
            });
        $resPenggajian = DepartemenModel::where('status', 1)->get()->map( function ($row) use ($bulan, $tahun) {
            $arr = $row->toArray();
            // Ambil semua karyawan di departemen ini
            $karyawan = KaryawanModel::with(['get_jabatan'])->whereIn('id_status_karyawan', [1, 2, 3, 7])->where('id_departemen', $arr['id'])->get();
            $payrollData = PayrollModel::where('id_departemen', $arr['id'])
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
                    'gaji_pokok' => $payroll->gaji_pokok ?? 0,
                    'gaji_bpjs' => $payroll->gaji_bpjs ?? 0,
                    'tunj_perusahaan' => $payroll->tunj_perusahaan ?? 0,
                    'tunj_tetap' => $payroll->tunj_tetap ?? 0,
                    'hours_meter' => $payroll->hours_meter ?? 0,
                    'pot_tunj_perusahaan' => $payroll->pot_tunj_perusahaan ?? 0,
                    'bpjsks_karyawan' => $payroll->bpjsks_karyawan ?? 0,
                    'bpjstk_jht_karyawan' => $payroll->bpjstk_jht_karyawan ?? 0,
                    'bpjstk_jp_karyawan' => $payroll->bpjstk_jp_karyawan ?? 0,
                    'bpjstk_jkm_karyawan' => $payroll->bpjstk_jkm_karyawan ?? 0,
                    'bpjstk_jkk_karyawan' => $payroll->bpjstk_jkk_karyawan ?? 0,
                    'bpjsks_perusahaan' => $payroll->bpjsks_perusahaan ?? 0,
                    'bpjstk_jht_perusahaan' => $payroll->bpjstk_jht_perusahaan ?? 0,
                    'bpjstk_jp_perusahaan' => $payroll->bpjstk_jp_perusahaan ?? 0,
                    'bpjstk_jkm_perusahaan' => $payroll->bpjstk_jkm_perusahaan ?? 0,
                    'bpjstk_jkk_perusahaan' => $payroll->bpjstk_jkk_perusahaan ?? 0,
                    'lembur' => $payroll->lembur ?? 0,
                    'pot_sedekah' => $payroll->pot_sedekah ?? 0,
                    'pot_pkk' => $payroll->pot_pkk ?? 0,
                    'pot_air' => $payroll->pot_air ?? 0,
                    'pot_rumah' => $payroll->pot_rumah ?? 0,
                    'pot_toko_alif' => $payroll->pot_toko_alif ?? 0,
                    'status_payroll' => $payroll ? 'Terdaftar' : 'Belum Terdaftar',
                    // Tambahkan data lain sesuai kebutuhan
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
            'data_non_dept' => $resNonDepartemen
        ];
        return view('HRD.penggajian.formSubmit', $data);
    }

    public function storeSubmitPenggajian(Request $request)
    {
        try {
            $bulan = $request->periode_bulan;
            $tahun = $request->periode_tahun;
            $_uuid = $request->periode_uuid;

            $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
            $group = 12; //pengajuan penggajian
            $ifSet = Hrdhelper::set_approval_cek($group, $id_depat_karyawan);
            if($ifSet > 0)
            {
                $dataH = PayrollHeaderModel::where('bulan', $bulan)->where('tahun', $tahun)->where('approval_key', $_uuid)->first();
                $dataUpdateHead = [
                    'status_pengajuan' => 1,
                    'current_approval_id' => Hrdhelper::set_approval_get_first($group, $id_depat_karyawan),
                ];
                PayrollHeaderModel::find($dataH->id)->update($dataUpdateHead);
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

    //old
    // public function tampilkan_karyawan_detail_gaji(Request $request)
    // {
    //     $id_dept = $request->pil_departemen;
    //     $bln = $request->pil_bulan;
    //     $thn = $request->pil_tahun;
    //     $res_persen_bpjs = SetupBPJSModel::first();
    //     if($id_dept==0)
    //     {
    //         $data['all_karyawan'] = KaryawanModel::with([
    //                     'get_jabatan'
    //                 ])
    //                 ->whereIn('id_status_karyawan', [1, 2, 3])
    //                 ->orderBy('id_jabatan')
    //                 ->orderBy('nik')
    //                 ->orderBy('tgl_masuk')->get()
    //                 ->map( function ($row) use ($bln, $thn) {
    //                     $arr = $row->toArray();
    //                     $query = PayrollModel::where('id_karyawan', $arr['id'])
    //                             ->where('bulan', $bln)
    //                             ->where('tahun', $thn);
    //                     if($query->get()->count() == 0)
    //                     {
    //                         $arr['payrol'] = null;
    //                     } else {
    //                         $arr['payrol'] = $query->first();

    //                     }
    //                     return $arr;
    //                 });
    //     } else {
    //         $data['all_karyawan'] = KaryawanModel::with([
    //                         'get_jabatan'
    //                     ])
    //                 ->whereIn('id_status_karyawan', [1, 2, 3])
    //                 ->where('id_departemen', $id_dept)
    //                 ->orderBy('id_jabatan')
    //                 ->orderBy('nik')
    //                 ->orderBy('tgl_masuk')->get()
    //                 ->map( function ($row) use ($bln, $thn) {
    //                     $arr = $row->toArray();
    //                     $query = PayrollModel::where('id_karyawan', $arr['id'])
    //                             ->where('bulan', $bln)
    //                             ->where('tahun', $thn);
    //                     if($query->get()->count() == 0)
    //                     {
    //                         $arr['payrol'] = null;
    //                     } else {
    //                         $arr['payrol'] = $query->first();

    //                     }
    //                     return $arr;
    //                 });
    //     }
    //     $data['persen_bpjs'] = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
    //     $data['persen_jht'] = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
    //     $data['persen_jp'] = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
    //     return view('HRD.penggajian.daftar_detail_gaji', $data);
    // }
}
