<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\MstHseLimbah;
use App\Models\Hse\MstHseUnitLimbah;
use App\Models\Hse\HsePlanLimbah;
use App\Models\Hse\HseRealisasiLimbah;
use App\Models\Hse\MstHsePerusahaanAngkutan;
use App\Models\Hse\HseBapLimbah;
use App\Models\Hse\HseInvestigasiKecelakaan;
use PDF;

class LimbahController extends Controller
{
    public function index(){
        $dt = MstHseLimbah::with('unit')->get();
        return response()->json($dt);
    }

    public function tambah_master_limbah(Request $request){
        $limbah = new MstHseLimbah();
        $limbah->nama = $request->nama;
        $limbah->unit_id = $request->unit;
        $limbah->harga_satuan = $request->harga_satuan;
        $limbah->kode = $request->kode;
        $limbah->jenis_limbah = $request->jenis_limbah;
        $limbah->save();
        return response()->json("tambah master limbah");
    }

    public function update_master_limbah(Request $request){
        $limbah = MstHseLimbah::find($request->existingId);
        $limbah->nama = $request->nama;
        $limbah->unit_id = $request->unit;
        $limbah->harga_satuan = $request->harga_satuan;
        $limbah->kode = $request->kode;
        $limbah->jenis_limbah = $request->jenis_limbah;
        $limbah->save();
        return response()->json("update master limbah");
    }

    public function get_master_unit_limbah(){
        $dt = MstHseUnitLimbah::all();
        return response()->json($dt);
    }

    public function simpan_master_unit_limbah(Request $request){
        $unit = new MstHseUnitLimbah();
        $unit->nama = $request->nama;
        $unit->save();
        return response()->json("tambah master unit limbah");
    }

    public function update_master_unit_limbah(Request $request){
        $unit = MstHseUnitLimbah::find($request->existingId);
        $unit->nama = $request->nama;
        $unit->save();
        return response()->json("update master unit limbah");
    }

    public function simpan_plan_limbah(Request $request){

        foreach($request->input('plan') as $key => $value){
            $plan = HsePlanLimbah::create([
                'tgl_plan' => $value['tgl_plan'],
                'id_limbah' => $value['id'],
                'qty' => $value['qty'],
                'harga_satuan' => $value['harga_satuan'],
                'sub_total' => $value['sub_total'],
                'keterangan' => $value['keterangan'],
            ]);
        }

        return response()->json("tambah plan limbah");
    }

    public function get_plan_limbah(){
        // $plan = HsePlanLimbah::with(['limbah' => function($query){
        //     $query->with('unit');
        // }])->get();
        try {
            $plan = HsePlanLimbah::with(['limbah.unit','realisasi'])->get();
            return response()->json($plan);
        } catch(\Exception $e){
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function simpan_realisasi_limbah(Request $request){
        if($request->input('realisasi')){
            $tgl_realisasi = $request->input('tgl_realisasi');
            $id_prsh_jasa_angkutan = $request->input('id_prsh_jasa_angkutan');

            foreach($request->input('realisasi') as $key => $value){
                $realisasi = HseRealisasiLimbah::create([
                    'id_plan_limbah' => $value['id'],
                    'id_limbah' => $value['id_limbah'],
                    'id_prsh_jasa_angkutan' => $id_prsh_jasa_angkutan,
                    'tgl_realisasi' => $tgl_realisasi,
                    'qty' => $value['qty_realisasi'],
                    'harga_satuan' => $value['harga_satuan'],
                    'sub_total' => $value['sub_total'],
                ]);

                $updatePlan = HsePlanLimbah::find($value['id']);
                $updatePlan->status = "realisasi";
                $updatePlan->save();
            }

            return response()->json("realisasi limbah berhasil disimpan");
        }
    }

    public function delete_plan_limbah($id){
        $plan = HsePlanLimbah::destroy($id);
        return response()->json("plan limbah id ".$id." telah di hapus");
    }

    public function create_perusahaan_angkutan(Request $request){
        $prsh = MstHsePerusahaanAngkutan::create([
            'nama' => $request->nama,
            'nama_pimpinan' => $request->nama_pimpinan,
            'alamat' => $request->alamat,
            'is_active' => $request->is_active,
            'email' => $request->email,
            'nomor_kontak' => $request->nomor_kontak,
        ]);

        return response()->json("perusahaan angkusan telah disimpan");
    }

    public function update_perusahaan_angkutan(Request $request, $id){
        $prsh = MstHsePerusahaanAngkutan::find($id);
        $prsh->nama = $request->nama;
        $prsh->nama_pimpinan = $request->nama_pimpinan;
        $prsh->alamat = $request->alamat;
        $prsh->is_active = $request->is_active;
        $prsh->email = $request->email;
        $prsh->nomor_kontak = $request->nomor_kontak;
        $prsh->save();
        return response()->json("perusahaan angkusan telah diupdate");
    }

    public function daftar_perusahaan_angkutan(){
        $prsh = MstHsePerusahaanAngkutan::where('is_active', 1)->get();
        return response()->json($prsh);
    }

    public function view_berita_acara_pengangkutan($idBap){
        /*
        $p2h = Inspection::with(['checkpoints','checkpoints.checkpointItems.equipment_category','location','equipment.equipment_category','officer'])
        ->where('id', $p2hId)->get();

        $pdf = PDF::loadview('Hse.p2h.pdf', compact('p2h'));
        return $pdf->stream();
        // return response()->json($p2h);
        */

        $bast = HseRealisasiLimbah::with(['plan','limbah','limbah.unit','perusahaan_angkutan'])->where('id_bap_limbah', $idBap)->get();
        $pdf = PDF::loadview('Hse.limbah.pdf', compact('bast'));
        return $pdf->stream();
        // return response()->json($bast)
    }

    public function create_bap_limbah(Request $request){

        if($request->has('items')){
            $bap = HseBapLimbah::create([
                'no_bap' => $request->no_bap,
                'tgl_bap' => $request->tgl_bap,
                'user_id' => $request->user_id,
            ]);

            foreach($request->items as $key => $value){
                $realisasi = HseRealisasiLimbah::find($value['realisasi']['id']);
                $realisasi->id_bap_limbah = $bap->id;
                $realisasi->save();

                $plan = HsePlanLimbah::find($value['realisasi']['id_plan_limbah']);
                $plan->status = "bap";
                $plan->save();
            }
        }

        return response()->json($bap);
    }

    public function get_bap_limbah(){

        try {
            // keep temporary
            // $bap = HseBapLimbah::with('realisasi.plan.limbah.unit','realisasi.perusahaan_angkutan')->get();
            $bap = HseBapLimbah::all();
            return response()->json($bap);
        } catch(\Exception $e){
            throw new HttpException(500, $e->getMessage());
        }
    }

}
