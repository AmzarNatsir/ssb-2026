<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\PerubahanStatusModel;
use App\Models\HRD\MutasiModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\SuratPeringatanModel;
use App\Models\HRD\PayrollModel;
use App\Models\HRD\SetupBPJSModel;
use App\Exports\KaryawanExport;
use App\Exports\StatusKaryawanExport;
use App\Exports\CutiIzinExport;
use App\Exports\MutasiExport;
use App\Exports\PayrollExport;
use App\Exports\PerdisExport;
use App\Exports\SPExport;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\CutiIzinModel;
use App\Models\HRD\PinjamanKaryawanModel;
use App\Models\HRD\PinjamanKaryawanMutasiModel;
use App\Models\HRD\SuratTeguranModel;
use App\Traits\General;
use App\Helpers\Hrdhelper;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PDF;
use Config;
class PelaporanController extends Controller
{
    use General;
    function get_karyawan_data()
    {
        return new KaryawanModel();
    }
    //Karyawan
    public function karyawan()
    {
        if(auth()->user()->id==1)
        {
            // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        } else {
            if(auth()->user()->karyawan->get_jabatan->id_level==4) {
                $data['all_departemen'] = DepartemenModel::where('status', 1)
                    ->where('id', auth()->user()->karyawan->id_departemen)->get();
            } else {
                $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
            }
        }
        return view('HRD.pelaporan.karyawan.index', $data);
    }
    public function filter_karyawan($id_departemen)
    {
        if($id_departemen==0)
        {
            $data['list_karyawan'] = KaryawanModel::where("hrd_karyawan.nik", "<>", "999999999")
            ->whereIn('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')
            ->get();
        } else {
            $data['list_karyawan'] = KaryawanModel::where('id_departemen', $id_departemen)
            ->where("hrd_karyawan.nik", "<>", "999999999")
            ->whereIn('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')
            ->get();
        }
        // $res_kary = $this->get_karyawan_data();
        // $data['list_karyawan'] = $res_kary->all_karyawan_per_dept($id_departemen);
        return view('HRD.pelaporan.karyawan.result_filter', $data);
    }
    public function print_karyawan($id_departemen)
    {
        if($id_departemen==0)
        {
            $all = KaryawanModel::where("hrd_karyawan.nik", "<>", "999999999")
            ->whereIn('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')
            ->get();
            $ket_dept = "Semua Departemen";
        } else {
            $all = KaryawanModel::where('id_departemen', $id_departemen)
            ->where("hrd_karyawan.nik", "<>", "999999999")
            ->whereIn('id_status_karyawan', [1, 2, 3, 7])
            ->orderBy('id_jabatan')
            ->orderBy('nik')
            ->orderBy('tgl_masuk')
            ->get();
            $ket_dept = DepartemenModel::find($id_departemen)->nm_dept;
        }
         //$this->get_karyawan_data()->all_karyawan_per_dept($id_departemen);
        $data['ket_departemen'] = $ket_dept;
        $data['list_karyawan'] = $all; //  KaryawanModel::wherein('id_status_karyawan', [1, 2, 3])->where('id_departemen', $id_departemen)->orderby('nik')->get();
        $pdf = PDF::loadview('HRD.pelaporan.karyawan.result_print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    public function excel_karyawan($id_departemen)
    {
        return (new KaryawanExport($id_departemen))->download('karyawanexport-'.$id_departemen.'.xlsx');
    }
    //perubahan status
    public function perubahan_status()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.pelaporan.perubahan_status.index', $data);
    }
    public function filter_perubahan_status($bulan, $tahun, $departemen)
    {
        if($departemen==0) {
            $data['list_data'] = PerubahanStatusModel::where('status_pengajuan', 2)->whereMonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        } else {
            $data['list_data'] = PerubahanStatusModel::where('status_pengajuan', 2)->where('id_departemen', $departemen)->whereMonth('tgl_surat', $bulan)->whereYear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        }

        return view('HRD.pelaporan.perubahan_status.result_filter', $data);
    }
    public function print_perubahan_status($bulan, $tahun, $departemen)
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['ket_tahun'] = $tahun;
        if($departemen==0) {
            $data['list_data'] = PerubahanStatusModel::where('status_pengajuan', 2)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        } else {
            $data['list_data'] = PerubahanStatusModel::where('status_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        }
        $pdf = PDF::loadview('HRD.pelaporan.perubahan_status.result_print', $data)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function excel_perubahan_status($bulan, $tahun, $departemen)
    {
        return (new StatusKaryawanExport($bulan, $tahun, $departemen))->download('perubahanstatusexport-'.$bulan.'-'.$tahun.'.xlsx');
    }
    //pelaporan mutasi/penempatan
    public function mutasi()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.pelaporan.mutasi.index', $data);
    }
    public function filter_mutasi($bulan, $tahun, $departemen)
    {
        if($departemen==0){
            $data['list_data'] = MutasiModel::where('status_pengajuan', 2)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        } else {
            $data['list_data'] = MutasiModel::where('status_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        }

        return view('HRD.pelaporan.mutasi.result_filter', $data);
    }
    public function print_mutasi($bulan, $tahun, $departemen)
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['ket_tahun'] = $tahun;
        if($departemen==0) {
            $data['list_data'] = MutasiModel::where('status_pengajuan', 2)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        } else {
            $data['list_data'] = MutasiModel::where('status_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_surat', $bulan)->whereyear('tgl_surat', $tahun)->orderby('tgl_surat')->get();
        }

        $pdf = PDF::loadview('HRD.pelaporan.mutasi.result_print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    public function excel_mutasi($bulan, $tahun, $departemen)
    {
        return (new MutasiExport($bulan, $tahun, $departemen))->download('mutasiexport-'.$bulan.'-'.$tahun.'.xlsx');
    }
    //cuti/izin
    public function cuti_izin()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.pelaporan.cuti_izin.index', $data);
    }
    public function filter_cuti_izin($bulan, $tahun, $kategori, $departemen)
    {
        if($kategori==1) //Cuti
        {
            if($departemen==0){
                $data['list_data'] = CutiModel::where('sts_pengajuan', 2)->wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->orderby('tgl_awal')->get();
            } else {
                $data['list_data'] = CutiModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->orderby('tgl_awal')->get();
            }

            return view('HRD.pelaporan.cuti_izin.result_filter_cuti', $data);
        } else {
            if($departemen==0){
                $data['list_data'] = IzinModel::where('sts_pengajuan', 2)->wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->orderby('tgl_awal')->get();
            } else {
                $data['list_data'] = IzinModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->orderby('tgl_awal')->get();
            }
            return view('HRD.pelaporan.cuti_izin.result_filter_izin', $data);
        }
    }
    public function print_cuti_izin($bulan, $tahun, $kategori)
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['ket_tahun'] = $tahun;
        $data['ket_kategori'] = ($kategori==1) ? "CUTI" : "IZIN";
        if($kategori==1) //Cuti
        {
            $data['list_data'] = CutiModel::wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->where('sts_pengajuan', 2)->orderby('tgl_awal')->get();
            $pdf = PDF::loadview('HRD.pelaporan.cuti_izin.result_print_cuti', $data)->setPaper('A4', 'potrait');
            return $pdf->stream();
        } else {
            $data['list_data'] = IzinModel::where('sts_pengajuan', 2)->wheremonth('tgl_awal', $bulan)->whereyear('tgl_awal', $tahun)->orderby('tgl_awal')->get();
            $pdf = PDF::loadview('HRD.pelaporan.cuti_izin.result_print_izin', $data)->setPaper('A4', 'potrait');
            return $pdf->stream();
        }
    }
    public function excel_cuti_izin($bulan, $tahun, $kategori, $departemen)
    {
        return (new CutiIzinExport($bulan, $tahun, $kategori, $departemen))->download('cuti_izinexport-'.$bulan.'-'.$tahun.'.xlsx');
    }
    public function print_form_cuti($id)
    {
        $newCutiController = new CutiIzinController();
        $cuti = CutiModel::with([
            'profil_karyawan',
            'get_jenis_cuti',
            'get_karyawan_pengganti',
            'get_current_approve'
        ])->find($id);
        $approval = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $cuti->approval_key)->orderBy('approval_level')->get();
        $levelMax = ApprovalModel::where('approval_key', $cuti->approval_key)->orderBy('approval_level')->max('approval_level');
        $masterCuti = CutiIzinModel::find($cuti->id_jenis_cuti);
        $countColumn = count($approval);
        $witdhColumn =  100 / ($countColumn+1);
        $quotaTerpakai = $newCutiController->ambil_quota_terpakai($cuti->id_karyawan, $cuti->id_jenis_cuti);
        $logo = General::getLogo();
        $kop_surat = Hrdhelper::get_kop_surat();
        $pdf = PDF::loadview('HRD.pelaporan.cuti_izin.print_form_cuti', compact('cuti', 'approval', 'countColumn', 'witdhColumn', 'masterCuti', 'quotaTerpakai', 'logo', 'levelMax', 'kop_surat'))->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    public function print_surat_cuti($id)
    {
        $newCutiController = new CutiIzinController();
        $cuti = CutiModel::with([
            'profil_karyawan',
            'get_jenis_cuti',
            'get_karyawan_pengganti',
            'get_current_approve'
        ])->find($id);
        $logo = General::getLogo();
        $kop_surat = Hrdhelper::get_kop_surat();
        $pdf = PDF::loadview('HRD.pelaporan.cuti_izin.print_surat_cuti', compact('cuti', 'logo', 'kop_surat'))->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    //perjalan dinas
    public function perdis()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.pelaporan.perdis.index', $data);
    }
    public function filter_perdis($bulan, $tahun, $departemen)
    {
        if($departemen==0) {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        } else {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        }

        return view('HRD.pelaporan.perdis.result_filter', $data);
    }
    public function print_perdis($bulan, $tahun, $departemen)
    {
        $data['ket_bulan'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['ket_tahun'] = $tahun;
        if($departemen==0) {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        } else {
            $data['list_data'] = PerdisModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_perdis', $bulan)->whereyear('tgl_perdis', $tahun)->orderby('tgl_perdis')->get();
        }

        $pdf = PDF::loadview('HRD.pelaporan.perdis.result_print', $data)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function excel_perdis($bulan, $tahun, $departemen)
    {
        return (new PerdisExport($bulan, $tahun, $departemen))->download('perdisexport-'.$bulan.'-'.$tahun.'.xlsx');
    }
    //surat peringatan
    public function sp()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        return view('HRD.pelaporan.sp.index', $data);
    }
    public function filter_sp($bulan, $tahun, $departemen, $kategori)
    {
        if($bulan==0 && $departemen==0) {
            if($kategori==1) {
                $data['list_data'] = SuratPeringatanModel::where('sts_pengajuan', 2)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            } else {
                $data['list_data'] = SuratTeguranModel::where('status_pengajuan', 2)->whereyear('tgl_st', $tahun)->orderby('tgl_st')->get();
            }
        }
        else if($departemen==0) {
            if($kategori==1) {
                $data['list_data'] = SuratPeringatanModel::where('sts_pengajuan', 2)->wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            } else {
                $data['list_data'] = SuratTeguranModel::where('status_pengajuan', 2)->wheremonth('tgl_st', $bulan)->whereyear('tgl_st', $tahun)->orderby('tgl_st')->get();
            }
        } else {
            if($kategori==1) {
                $data['list_data'] = SuratPeringatanModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            } else {
                $data['list_data'] = SuratTeguranModel::where('status_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            }

        }

        return view('HRD.pelaporan.sp.result_filter', $data);
    }
    public function print_sp($bulan, $tahun, $departemen)
    {
        if($bulan=="0" && $departemen=="0") {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            $ket_bulan = "0";
        } else if($departemen==0) {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            $ket_bulan = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        } else {
            $result = SuratPeringatanModel::where('sts_pengajuan', 2)->where('id_departemen', $departemen)->wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
            $ket_bulan = \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        }
        $data['ket_bulan'] = $ket_bulan; // \App\Helpers\Hrdhelper::get_nama_bulan($bulan);
        $data['ket_tahun'] = $tahun;

        $data['list_data'] = $result; // SuratPeringatanModel::wheremonth('tgl_sp', $bulan)->whereyear('tgl_sp', $tahun)->orderby('tgl_sp')->get();
        $pdf = PDF::loadview('HRD.pelaporan.sp.result_print', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    public function excel_sp($bulan, $tahun, $departemen)
    {
        return (new SPExport($bulan, $tahun, $departemen))->download('suratperingatanexport-'.$bulan.'-'.$tahun.'.xlsx');
    }
    //penggajian
    public function penggajian()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.pelaporan.penggajian.index', $data);
    }
    public function filter_penggajian($bulan, $tahun, $departemen)
    {
        if($departemen==0)
        {
            $data['list_data'] = PayrollModel::where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        } else {
            $data['list_data'] = PayrollModel::where('id_departemen', $departemen)->where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        }
        return view('HRD.pelaporan.penggajian.result_filter', $data);
    }
    public function print_penggajian($bulan, $tahun, $departemen)
    {
        $data['ket_periode'] = \App\Helpers\Hrdhelper::get_nama_bulan($bulan). " ".$tahun;
        if($departemen==0)
        {
            $data['departemen'] = "All Departemen";
            $data['list_data'] = PayrollModel::where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        } else {
            $data['departemen'] = DepartemenModel::find($departemen)->nm_dept;
            $data['list_data'] = PayrollModel::where('id_departemen', $departemen)->where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        }
        $pdf = PDF::loadview('HRD.pelaporan.penggajian.result_print', $data)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function excel_penggajian($bulan, $tahun, $departemen)
    {
        return (new PayrollExport($bulan, $tahun, $departemen))->download('daftargajikaryawan-'.$bulan.'-'.$tahun.'.xlsx');
    }
    //detail tunjangan
    public function detailTunjangan($id)
    {
        $payroll = PayrollModel::find($id);
        $karyawan = KaryawanModel::find($payroll->id_karyawan);
        $data = [
            'profil' => $karyawan,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($payroll->bulan)." ".$payroll->tahun,
            'payroll' => $payroll
        ];
        return view('HRD.pelaporan.penggajian.detail_tunjangan', $data);
    }

    //detail potongan
    public function detailPotongan($id)
    {
        $payroll = PayrollModel::find($id);
        $karyawan = KaryawanModel::find($payroll->id_karyawan);
        $data = [
            'profil' => $karyawan,
            'ket_periode' => \App\Helpers\Hrdhelper::get_nama_bulan($payroll->bulan)." ".$payroll->tahun,
            'payroll' => $payroll
        ];
        return view('HRD.pelaporan.penggajian.detail_potongan', $data);
    }

    //BPJS Ketenagakerjaan
    public function bpjs_ketenagakerjaan()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.pelaporan.bpjs_ketenagakerjaan.index', $data);
    }
    public function filter_bpjs_ketenagakerjaan($bulan, $tahun, $departemen)
    {
        $res_persen_bpjs = SetupBPJSModel::first();
        $data['persen_jht_kary'] = (empty($res_persen_bpjs->jht_karyawan)) ? '0' : $res_persen_bpjs->jht_karyawan;
        $data['persen_jht_pers'] = (empty($res_persen_bpjs->jht_perusahaan)) ? '0' : $res_persen_bpjs->jht_perusahaan;
        $data['persen_jkk_kary'] = (empty($res_persen_bpjs->jkk_karyawan)) ? '0' : $res_persen_bpjs->jkk_karyawan;
        $data['persen_jkk_pers'] = (empty($res_persen_bpjs->jkk_perusahaan)) ? '0' : $res_persen_bpjs->jkk_perusahaan;
        $data['persen_jkm_kary'] = (empty($res_persen_bpjs->jkm_karyawan)) ? '0' : $res_persen_bpjs->jkm_karyawan;
        $data['persen_jkm_pers'] = (empty($res_persen_bpjs->jkm_perusahaan)) ? '0' : $res_persen_bpjs->jkm_perusahaan;
        $data['persen_jp_kary'] = (empty($res_persen_bpjs->jp_karyawan)) ? '0' : $res_persen_bpjs->jp_karyawan;
        $data['persen_jp_pers'] = (empty($res_persen_bpjs->jp_perusahaan)) ? '0' : $res_persen_bpjs->jp_perusahaan;
        if($departemen==0)
        {
            $data['list_data'] = PayrollModel::where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        } else {
            $data['list_data'] = PayrollModel::where('id_departemen', $departemen)->where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        }

        return view('HRD.pelaporan.bpjs_ketenagakerjaan.result_filter', $data);
    }
    //bpjs kesehatan
    public function bpjs_kesehatan()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.pelaporan.bpjs_kesehatan.index', $data);
    }
    public function filter_bpjs_kesehatan($bulan, $tahun, $departemen)
    {
        $res_persen_bpjs = SetupBPJSModel::first();
        $data['persen_bpjsks_kary'] = (empty($res_persen_bpjs->bpjsks_karyawan)) ? '0' : $res_persen_bpjs->bpjsks_karyawan;
        $data['persen_bpjsks_pers'] = (empty($res_persen_bpjs->bpjsks_perusahaan)) ? '0' : $res_persen_bpjs->bpjsks_perusahaan;
        if($departemen==0)
        {
            $data['list_data'] = PayrollModel::where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        } else {
            $data['list_data'] = PayrollModel::where('id_departemen', $departemen)->where('bulan', $bulan)->where('tahun', $tahun)->where('flag', 1)->orderby('id_karyawan', 'asc')->get();
        }
        return view('HRD.pelaporan.bpjs_kesehatan.result_filter', $data);
    }

    //pinjaman karyawan
    public function pinjamanKaryawan()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.pelaporan.pinjaman_karyawan.index', $data);
    }

    public function filterPinjamanKaryawan($bulan, $tahun, $departemen)
    {
        if($departemen==0)
        {
            $data = [
                'list_pinjaman_karyawan' => PinjamanKaryawanModel::select('hrd_pinjaman_karyawan.*', 'hrd_karyawan.nm_lengkap')
                ->leftJoin('hrd_karyawan', 'hrd_pinjaman_karyawan.id_karyawan', '=', 'hrd_karyawan.id')
                ->whereMonth('hrd_pinjaman_karyawan.tgl_pengajuan', $bulan)
                ->whereYear('hrd_pinjaman_karyawan.tgl_pengajuan', $tahun)
                ->where('hrd_pinjaman_karyawan.status_pengajuan', 2)->where('hrd_pinjaman_karyawan.aktif', 'y')->get()
                ->map( function ($items) {
                    $arr = $items->toArray();
                    $arr['outs'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->whereNull('status')->sum('nominal');
                    return $arr;
                })

            ];
        } else {
            $data = [
                'list_pinjaman_karyawan' => PinjamanKaryawanModel::select('hrd_pinjaman_karyawan.*', 'hrd_karyawan.nm_lengkap')
                ->leftJoin('hrd_karyawan', 'hrd_pinjaman_karyawan.id_karyawan', '=', 'hrd_karyawan.id')
                ->whereMonth('hrd_pinjaman_karyawan.tgl_pengajuan', $bulan)
                ->whereYear('hrd_pinjaman_karyawan.tgl_pengajuan', $tahun)
                ->where('hrd_karyawan.id_departemen', $departemen)
                ->where('hrd_pinjaman_karyawan.status_pengajuan', 2)->where('hrd_pinjaman_karyawan.aktif', 'y')->get()
                ->map( function ($items) {
                    $arr = $items->toArray();
                    $arr['outs'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->whereNull('status')->sum('nominal');
                    return $arr;
                })

            ];
        }
        return view('HRD.pelaporan.pinjaman_karyawan.result_filter', $data);
    }
}
