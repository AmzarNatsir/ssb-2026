<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use Illuminate\Http\Request;

class JobDescController extends Controller
{
    public function index()
    {
        $data['all_dept'] = DepartemenModel::All();
        return view('HRD.jobdesc.index', $data);
    }

    public function data($departemen)
    {
        if($departemen==0)
        {
            $data['list_data'] = JabatanModel::orderBy('id_level', 'asc')->get();
        } else {
            $data['list_data'] = JabatanModel::where('id_dept', $departemen)->orderBy('id_level', 'asc')->get();
        }
        return view('HRD.jobdesc.list', $data);
    }
}
