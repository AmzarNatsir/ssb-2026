<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\MstHseKategoricidera;
use App\Models\Hse\MstHseCidera;
use App\Models\Hse\MstHseJenisKejadian;
use App\Models\Hse\HseInvestigasiKecelakaan;
use App\Models\Hse\HseBak;
class InvestigasiKecelakaanController extends Controller
{
    public function master_kategori_cidera(){
        $query = MstHseKategoricidera::with('cidera')->get();
        return response()->json($query);
    }

    public function simpan_kategori_cidera(Request $request){
        $query = MstHseKategoriCidera::create([
            'name' => $request->name
        ]);
        return response()->json($query);
    }

    public function update_kategori_cidera(Request $request, $id){
        $query = MstHseKategoriCidera::findOrFail($id);
        $query->name = $request->name;
        $query->save();
        return response()->json($query);
    }

    public function master_cidera(){
        $query = MstHseCidera::with('kategori_cidera')->get();
        return response()->json($query);
    }

    public function simpan_master_cidera(Request $request){
        $query = MstHseCidera::create([
            'name' => $request->name,
            'id_kategori_cidera' => $request->id_kategori_cidera
        ]);
        return response()->json($query);
    }

    public function update_master_cidera(Request $request, $id){
        $query = MstHseCidera::findOrFail($id);
        $query->name = $request->name;
        $query->id_kategori_cidera = $request->id_kategori_cidera;
        $query->save();
        return response()->json($query);
    }

    public function master_jenis_kejadian(){
        $query = MstHseJenisKejadian::all();
        return response()->json($query);
    }

    public function simpan_jenis_kejadian(Request $request){
        $query = MstHseJenisKejadian::create([
            'name' => $request->name
        ]);
        return response()->json($query);
    }

    public function update_jenis_kejadian(Request $request, $id){
        $query = MstHseJenisKejadian::findOrFail($id);
        $query->name =  $request->name;
        $query->save();
        return response()->json($query);
    }

    // BAK
    public function simpan_bak(Request $request){
        $query = HseBak::create([
            'no_form' => $request->no_form,
            'nama_site' => $request->nama_site,
            'tgl_kejadian' => $request->tgl_kejadian,
            'jam_kejadian' => $request->jam_kejadian,
            'id_karyawan' => $request->id_karyawan,
            'user_id' => $request->user_id,
            'kronologis' => $request->kronologis
        ]);
        return response()->json($query);
    }

    // UPDATE BAK
    public function update_bak(Request $request, $id){

        $query = HseBak::findOrFail($id);
        $query->no_form = $request->no_form;
        $query->nama_site = $request->nama_site;
        $query->tgl_kejadian = $request->tgl_kejadian;
        $query->jam_kejadian = $request->jam_kejadian;
        $query->id_karyawan = $request->id_karyawan;
        $query->user_id = $request->user_id;
        $query->kronologis = $request->kronologis;
        $query->save();
        return response()->json($query);

    }

    // List Bak + INvestigasi
    public function list_bak(){
        $query = HseBak::with('investigasi')->get();
        return response()->json($query);
    }

    public function view_bak_detail($id){
        $query = HseBak::findOrFail($id);
        return response()->json($query);
    }

    // delete BAK
    public function delete_bak($id){
        $query = HseBak::destroy($id);
        return response()->json($query);
    }

    public function create_lap_investigasi(Request $request){
        // try {

            $query = HseInvestigasiKecelakaan::updateOrCreate([
                'id' => $request->id_lap_investigasi
            ],[
                'no_dokumen' => $request->no_dokumen,
                'no_revisi' => $request->no_revisi,
                'no_form' => $request->no_form,
                'user_id' => $request->user_id,
                'fakta_investigasi' => $request->fakta_investigasi,
                'jenis_kejadian' => $request->jenis_kejadian,
                'rincian_bagian_tubuh' => $request->rincian_bagian_tubuh,
                'rincian_accident_lingkungan' => $request->rincian_accident_lingkungan,
                'rincian_kerusakan_alat' => $request->rincian_kerusakan_alat,
                'ketua_tim' => $request->ketua_tim,
                'anggota_tim' => $request->anggota_tim,
                'saksi' => $request->saksi
            ]);

            // $query = HseInvestigasiKecelakaan::store($request->all());
            $bak = HseBak::findOrFail($request->id_bak);
            $bak->id_investigasi_kecelakaan = $query->id;
            $bak->save();

            return response()->json($query);

        // } catch($error){
        //     dd($e);
        //     // throw new HttpException(500, $e);
        // }
    }

    public function detail_lap_investigasi($id){
        // $query = HseInvestigasiKecelakaan::findOrFail($id);
        $query = HseBak::with('investigasi')->findOrFail($id);
        return response()->json($query->investigasi);
    }

    public function update_lap_investigasi(Request $request, $id){
        // $query = HseInvestigasiKecelakaan::findOrFail($id);
        // $query->no_dokumen = $request->no_dokumen;
        // $query->no_revisi = $request->no_revisi;
        // $query->no_form = $request->no_form;
        // $query->user_id = $request->user_id;
        // $query->
    }

}
