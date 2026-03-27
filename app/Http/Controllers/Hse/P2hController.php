<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\HseP2h;

class P2hController extends Controller
{

    public function get_all(Request $request){
        if($request->has(['tgAwal','tgAkhir'])){
            $p2h = HseP2h::whereDate('tgl_inspeksi', '>=', $request->tgAwal)
            ->whereDate('tgl_inspeksi', '<=', $request->tgAkhir)->get();
            return response()->json($p2h);
        } else {
            $p2h = HseP2h::all();
            return response()->json($p2h);
        }
    }

    public function store(Request $request){

        $form_file = $request->form_file->store('public/p2h');

        $p2h = HseP2h::create([
            "jenis_p2h" => $request->jenis_p2h,
            "kategori_kendaraan" => $request->kategori_kendaraan,
            "no_unit" => $request->no_unit,
            "tgl_inspeksi" => $request->tgl_inspeksi,
            "hm_awal" => $request->hm_awal,
            "hm_akhir" => $request->hm_akhir,
            "lokasi" => $request->lokasi,
            "pelaksana" => $request->pelaksana,
            "penanggung_jawab_unit" => $request->penanggung_jawab_unit,
            "safety_officer" => $request->safety_officer,
            "form_file" => str_replace('public/p2h/', "", $form_file),
            "penggantian_alat_keselamatan" => $request->penggantian_alat_keselamatan,
        ]);

        return response()->json($p2h);
    }

    public function show($id){
        $p2h = HseP2h::find($id);
        return response()->json($p2h);
    }

    public function update(Request $request, $id){
        // return response()->json($request);
        // http://localhost:5173/p2h/[object%20File]
        //return response()->json(gettype($request->form_file));
        $form_file = gettype($request->form_file) === "string" ? $request->form_file : $request->form_file->store('public/p2h');
        $p2h = HseP2h::where('id', $id)->update([
            "jenis_p2h" => $request->jenis_p2h,
            "kategori_kendaraan" => $request->kategori_kendaraan,
            "no_unit" => $request->no_unit,
            "tgl_inspeksi" => $request->tgl_inspeksi,
            "hm_awal" => $request->hm_awal,
            "hm_akhir" => $request->hm_akhir,
            "lokasi" => $request->lokasi,
            "pelaksana" => $request->pelaksana,
            "penanggung_jawab_unit" => $request->penanggung_jawab_unit,
            "safety_officer" => $request->safety_officer,
            "form_file" => str_replace('public/p2h/', "", $form_file),
            "penggantian_alat_keselamatan" => $request->penggantian_alat_keselamatan,
        ]);

        return response()->json($p2h);
    }

    public function delete($id){
        $p2h = HseP2h::find($id);
        $p2h->delete();

        return response()->json($p2h);
    }

    public function getFile($filename)
    {
        $path = storage_path('app/public/p2h/' . $filename);
        return response()->file($path);
        // $str = "public/safety-induction/6mYVqRX9nZHJxGcEDqHCfmGYIfWON7lCnvzPn6gw.png";
        // return response()->json(str_replace('public/safety-induction/', "", $str));
    }
}
