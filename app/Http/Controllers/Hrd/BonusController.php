<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\BonusTemplate;
use App\Http\Controllers\Controller;
use App\Imports\PeriodeBonusImport;
use App\Models\HRD\BonusHeaderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class BonusController extends Controller
{
    public function index()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        $data['PeriodeBonus'] = BonusHeaderModel::where('tahun', date('Y'))->get();
        return view('HRD.penggajian.bonus.index', $data);
    }

    public function simpanPeriodeBonus(Request $request)
    {
        try {
            $bulan = $request->pil_periode_bulan;
            $tahun = $request->inp_periode_tahun;
            $_uuid = Str::uuid();
            $checkData = BonusHeaderModel::where('bulan', $bulan)->where('tahun', $tahun)->get()->count();
            if($checkData==0)
            {
                $dataInsert = [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'approval_key' => $_uuid,
                    'is_draft' => 1,
                    'diajukan_oleh' => auth()->user()->id
                ];
                BonusHeaderModel::create($dataInsert);
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

    //tools
    public function downloadtemplateBonus($tahun, $bulan)
    {
        return Excel::download(new BonusTemplate($tahun, $bulan), 'templatePeriodeBonusKaryawan.xlsx');
    }

    public function formImportPeriodeBonus()
    {
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view("HRD.penggajian.tools.form_import_bonus");
    }
    public function doImportPeriodeBonus()
    {
        try {
            Excel::import(new PeriodeBonusImport, request()->file_imp);
            return back()->withStatus('Excel file import succesfully');
        } catch (\Exception $ex) {
            return back()->withStatus($ex->getMessage());
        }
    }
}
