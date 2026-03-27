<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\auth\PermissionModel;
use App\Models\HRD\MemoModel;
use App\Models\HRD\PelatihanHeaderModel;
use App\Models\HRD\SetupHariLiburModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['list_memo'] = MemoModel::where('status', 1)->orderBy('tgl_post', 'desc')->get();
        $data['list_hari_libur'] = SetupHariLiburModel::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->orderBy('tanggal')->get();
        $data['hari_ini_pelatihan'] = PelatihanHeaderModel::with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')
        ->where('status_pelatihan', '>=', 2)->whereMonth('tanggal_awal', date('m'))->WhereYear('tanggal_awal', date('Y'))->get();
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
