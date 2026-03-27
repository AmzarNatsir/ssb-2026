<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\KaryawanModel;
use Carbon\Carbon;
use Config;

class DashboardController extends Controller
{
    public function index()
    {
        $all_sts_karyawan = Config::get("constants.status_karyawan");
        $curr_date = Carbon::now();
        $res_dept = DepartemenModel::where("status", 1)->get();
        foreach($res_dept as $dept){
            $jml_karyawan = count(KaryawanModel::where("id_departemen", $dept->id)->get());
            $arr_data_1[] = array(
                "nm_dept"=>$dept->nm_dept,
                "jml_karyawan"=>$jml_karyawan
            );
        }

        //$arr_status = array("1"=>"Training", "2"=>"Kontrak", "3"=>"Tetap");

        foreach($all_sts_karyawan as $key => $value)
        {
            $jml_karyawan = count(KaryawanModel::where("id_status_karyawan", $key)->get());
            $arr_data_2[] = array(
                'status' => $value,
                'jml_karyawan' => $jml_karyawan
            );
        }
        //dd($arr_data_1);
        $usia_1 = count(\DB::table("hrd_karyawan")
                ->selectRaw('timestampdiff(year, tgl_lahir, curdate()) as umur')
                ->whereRaw('timestampdiff(year, tgl_lahir, curdate()) <= 25 AND id_status_karyawan IS NOT NULL')
                ->get());
        $usia_2 = count(\DB::table("hrd_karyawan")
                ->selectRaw('timestampdiff(year, tgl_lahir, curdate()) as umur')
                ->whereRaw('timestampdiff(year, tgl_lahir, curdate()) between 26 and 30 AND id_status_karyawan IS NOT NULL')
                ->get());
        $usia_3 = count(\DB::table("hrd_karyawan")
                ->selectRaw('timestampdiff(year, tgl_lahir, curdate()) as umur')
                ->whereRaw('timestampdiff(year, tgl_lahir, curdate()) between 31 and 40 AND id_status_karyawan IS NOT NULL')
                ->get());
        $usia_4 = count(\DB::table("hrd_karyawan")
                ->selectRaw('timestampdiff(year, tgl_lahir, curdate()) as umur')
                ->whereRaw('timestampdiff(year, tgl_lahir, curdate()) > 40 AND id_status_karyawan IS NOT NULL')
                ->get());
       // $usia_1 = \DB::select("SELECT COUNT(DATEDIFF(yy, tgl_lahir, getdate())) as umur_saat_ini from hrd_karyawan where id_status_karyawan IN (1, 2, 3) AND DATEDIFF(yy, tgl_lahir, getdate()) <= 25");
        
        //dd($usia_4);
        $data['usia_1'] = $usia_1;
        $data['usia_2'] = $usia_2;
        $data['usia_3'] = $usia_3;
        $data['usia_4'] = $usia_4;
        $data['data_chart_1'] = $arr_data_1;
        $data['data_chart_2'] = $arr_data_2;
        return view('HRD.dashboard.index', $data);
    }
}
