<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\LemburModel;
use Illuminate\Http\Request;

class LemburController extends Controller
{
    public function index()
    {
        $data = [
            'pengajuan' =>  LemburModel::whereIn('status_pengajuan', [1])->get()->count(),
            'lembur_hari_ini' => LemburModel::whereIn('status_pengajuan', [2])->where('tgl_pengajuan', '=', date('Y-m-d'))->get()->count(),
            'lembur_bulan_ini' => LemburModel::where('status_pengajuan', 2)->whereMonth('tgl_pengajuan', date('m'))->whereYear('tgl_pengajuan', date('Y'))->get()->count()
        ];
        return view("HRD.lembur.index", $data);
    }

    public function show_data($filter) {
        if($filter=="pengajuan")
        {
            $data['list_pengajuan'] = LemburModel::with([
                'get_profil_karyawan',
                'get_current_approve'
            ])->whereIn('status_pengajuan', [1])->get();
            $data['ket'] = "Daftar Pengajuan Lembur";
            return view('HRD.lembur.result_filter', $data);
        }
        if($filter=="today")
        {
            $data['list_pengajuan'] = LemburModel::with([
                'get_profil_karyawan',
                'get_current_approve'
            ])->whereIn('status_pengajuan', [2])->where('tgl_pengajuan', '=', date('Y-m-d'))->get();
            $data['ket'] = "Karyawan Lembur Hari Ini";
            return view('HRD.lembur.result_filter', $data);
        }
        if($filter=="month")
        {
            $data['list_pengajuan'] = LemburModel::with([
                'get_profil_karyawan',
                'get_current_approve'
            ])->where('status_pengajuan', 2)->whereMonth('tgl_pengajuan', date('m'))->whereYear('tgl_pengajuan', date('Y'))->get();
            $data['ket'] = "Karyawan Lembur Bulan Ini";
            return view('HRD.lembur.result_filter', $data);
        }
    }

    public function detail_data($id)
    {
        $main = LemburModel::with([
            'get_profil_karyawan',
            'get_current_approve'
        ])->find($id);
        $data = [
            'profil' => $main,
            'hirarki_persetujuan' => ApprovalModel::where('approval_key', $main->approval_key)->orderBy('approval_level')->get()
        ];
        return view('HRD.lembur.detail', $data);
    }
}
