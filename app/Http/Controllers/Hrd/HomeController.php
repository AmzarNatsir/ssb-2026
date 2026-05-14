<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\auth\PermissionModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\LemburModel;
use App\Models\HRD\MemoModel;
use App\Models\HRD\MutasiModel;
use App\Models\HRD\PelatihanHeaderModel;
use App\Models\HRD\SetupHariLiburModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bulanIni = date('m');
        $tahunIni = date('Y');

        $data['list_memo']           = MemoModel::where('status', 1)->orderBy('tgl_post', 'desc')->get();
        $data['list_hari_libur']     = SetupHariLiburModel::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->orderBy('tanggal')->get();
        $data['hari_ini_pelatihan']  = PelatihanHeaderModel::with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')
            ->where('status_pelatihan', '>=', 2)->whereMonth('tanggal_awal', $bulanIni)->whereYear('tanggal_awal', $tahunIni)->get();

        // Statistik
        $data['stat_karyawan']       = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->count();
        $data['stat_cuti_pending']   = CutiModel::where('sts_pengajuan', 1)->whereMonth('tgl_awal', $bulanIni)->whereYear('tgl_awal', $tahunIni)->count();
        $data['stat_lembur_pending'] = LemburModel::where('status_pengajuan', 1)->whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count();
        $data['stat_mutasi_pending'] = MutasiModel::where('status_pengajuan', 1)->count();

        // Karyawan ulang tahun bulan ini
        $data['ulang_tahun']         = KaryawanModel::with('get_jabatan', 'get_departemen')
            ->whereIn('id_status_karyawan', [1, 2, 3])
            ->whereMonth('tgl_lahir', $bulanIni)
            ->orderByRaw('DAY(tgl_lahir)')
            ->get();

        return view('HRD.utama', $data);
    }

    public function getPelatihan($filter)
    {
        // if($filter==1)
        // {
            $data['data_pelatihan'] = PelatihanHeaderModel::with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')
            ->where('status_pelatihan', ">=", 2)->whereMonth('tanggal_awal', $filter)->WhereYear('tanggal_awal', date('Y'))->get();
            // ->where(function($sub){
            //     $sub->where('tanggal_awal', '>=', date('Y-m-d'))
            //         ->orWhere('tanggal_sampai', '<=', date('Y-m-d'));
            // })->get();
        // } elseif($filter==2)
        // {
        //     $data['data_pelatihan'] = PelatihanHeaderModel::with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')
        //     ->where('status_pelatihan', ">=", 2)
        //     ->whereMonth('tanggal_awal', date('m'))
        //     ->whereYear('tanggal_awal', date('Y'))
        //     ->get();
        // } else {
        //     $data['data_pelatihan'] = PelatihanHeaderModel::with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')
        //     ->where('status_pelatihan', ">=", 2)
        //     ->whereYear('tanggal_awal', date('Y'))
        //     ->get();
        // }
        return view('HRD.utama.result_pelatihan', $data);
    }

    public function utama()
    {
        return view('welcome');
    }
}
