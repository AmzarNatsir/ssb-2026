<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HRD\DepartemenModel;
use App\Models\HRD\KaryawanModel;

class OpsiController extends Controller
{
    // all departemen
    public function list_departemen(){
        $query = DepartemenModel::where('status', 1)->orderBy('nm_dept', 'ASC')->get();
        return response()->json($query);
    }

    // karyawan berdasarkan departmen
    public function list_karyawan_by_departemen($id_dept){
        $query = KaryawanModel::with([
            'get_departemen' => function ($q){
                $q->select('id', 'nm_dept');
            },
            'get_jabatan' => function ($q){
                $q->select('id', 'nm_jabatan');
            }
        ])
        ->select('id','nik', 'nm_lengkap', 'id_departemen', 'id_subdepartemen', 'id_jabatan')
        ->where('id_departemen', $id_dept)->get();
        return response()->json($query);
    }
}
