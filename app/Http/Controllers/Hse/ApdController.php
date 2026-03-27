<?php
namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

use App\Models\Hse\MstApd;
use App\Models\Hse\ApdKeluar;
use App\Models\Hse\HseApdOrder;
use App\Models\Hse\HsePesanApd;
use App\Models\Hse\hseApdScore;

use PDF;

class ApdController extends Controller
{
    public function index()
    {
        $test = HsePesanApd::all();
        return response()->json($test);
    }

    public function list_apd()
    {
        $queries = MstApd::all();
        return response()->json($queries);
    }

    public function insert_apd(Request $request)
    {
        try {
            $queries = MstApd::create([
                'nama_apd' => $request->nama_apd,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'stock' => $request->stock,
                'status' => $request->status,
                'masa_pakai_bulan' => $request->masa_pakai_bulan,
                'masa_ganti_bulan' => $request->masa_ganti_bulan
            ]);

            if($queries){
                return response()->json([
                    "status" => "sukses",
                    "message" => "berhasil menyimpan data apd"
                ]);
            }
        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getApdById($idApd)
    {
        try {
            $queries = MstApd::where('id', $idApd)->first();
            if(!$queries) return response()->json([], 200);
            return response()->json($queries, 200);
        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateApd(Request $request, $idApd)
    {
        try {
            $apd = MstApd::find($idApd);
            $apd->nama_apd = $request->nama_apd;
            $apd->tanggal_pembelian = $request->tanggal_pembelian;
            $apd->status = $request->status;
            $apd->masa_pakai_bulan = $request->masa_pakai_bulan;
            $apd->masa_ganti_bulan = $request->masa_ganti_bulan;
            $apd->save();
        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function ApdOptions()
    {
        try {
            $queries = MstApd::select(['id','nama_apd as name'])->orderBy('nama_apd', 'asc')->get();
            return response()->json([
                'data' => $queries
            ]);
        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function simpan_form_order(Request $request){

        foreach($request->order as $key => $value){
            $order = HseApdOrder::create([
                'id_apd' => $value['id_apd'],
                'tanggal_order' => $value['tanggal_order'],
                'no_order' => $value['no_order'],
                'id_pengorder' => $value['id_pengorder'],
                'qty' => $value['qty'],
            ]);
        }

        return response()->json($order);
    }

    public function view_nota_order($no_order){
        $query = HseApdOrder::with(['apd','karyawan'])->where('no_order', $no_order)->get();
        return response()->json($query);
    }

    public function view_pdf_nota_order($no_order){
        $query = HseApdOrder::with(['apd','karyawan'])->where('no_order', $no_order)->get();
        $pdfOutput = PDF::loadview('Hse.apd.pdf_nota_order', compact('query'));
        return $pdfOutput->stream();
    }

    public function list_form_order(){
        $order = HseApdOrder::with(['apd','karyawan'])->get();
        return response()->json($order);
    }

    public function simpan_bast(Request $request){

        foreach($request->bast as $key => $value){

            $bast = ApdKeluar::create([
                'no_register' => $value['no_register'],
                'id_project' => $value['id_project'],
                'id_apd' => $value['id_apd'],
                'id_karyawan_peminjam' => $value['id_karyawan_peminjam'],
                'id_karyawan_menyerahkan' => 1,
                'qty_out' => $value['qty_out'],
                'tanggal_keluar' => $value['tanggal_keluar'],
                'keterangan' => $value['keterangan'],
            ]);
        }

        return response()->json($bast);

    }

    public function index_apd_keluar(){
        $apd_keluar = ApdKeluar::select(
            'no_register',
            'tanggal_keluar',
            \DB::raw('count(id_karyawan_peminjam) as count_kary')
        )
        ->groupBy('no_register','tanggal_keluar')
        ->orderBy('tanggal_keluar', 'asc')->get();
        return response()->json($apd_keluar);
    }

    public function list_tanda_terima_apd($no_register){
        $query = ApdKeluar::with(['karyawan.get_jabatan','project','apd'])
        ->where('no_register', $no_register)
        ->get();
        return response()->json($query);
    }

    public function view_pdf_tanda_terima_apd($no_register){
        $query = ApdKeluar::with([
            'karyawan.get_jabatan',
            'project',
            'apd'
        ])
        ->where('no_register', $no_register)
        ->get();

        $pdfOutput = PDF::loadview('Hse.apd.pdf_tanda_terima', compact('query'));
        return $pdfOutput->stream();
    }

    public function submit_penilaian(Request $request){

        foreach($request->item_penilaian as $key => $value){

            if($value['item_name'] === "pemahaman kta (kondisi tidak aman)"){
                $score_pemahaman_kta = $value['item_score'];
            } else if($value['item_name'] === "pemahaman tta (tindakan tidak aman)"){
                $score_pemahaman_tta = $value['item_score'];
            } else if ($value['item_name'] === "perawatan apd"){
                $score_perawatan_apd = $value['item_score'];
            }
        }

        $query = HseApdScore::create([
            'id_karyawan' => $request->id_kary,
            'id_apd' => $request->id_apd,
            'tgl_penilaian' => $request->tgl_penilaian,
            'item_penilaian' => $request->item_penilaian,
            'score_pemahaman_kta' => $score_pemahaman_kta,
            'score_pemahaman_tta' => $score_pemahaman_tta,
            'score_perawatan_apd' => $score_perawatan_apd
        ]);

        return response()->json($query);
    }

    public function table_score(){
        $query = HseApdScore::with(['apd','karyawan'])->orderBy('tgl_penilaian', 'desc')->get();
        return response()->json($query);
    }
}
