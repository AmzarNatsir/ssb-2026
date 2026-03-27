<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\HRD\KaryawanModel;
use App\Models\HRD\JabatanModel;
use App\Models\Hse\SafetyInduction;
use App\Models\Hse\SafetyInductionSteps;
use App\User;

use App\Models\Hse\HseSafetyInduction;
use App\Models\Hse\HseJobSafetyAnalisis;
use App\Models\Hse\HseTestPemahamanSafety;

use Illuminate\Support\Facades\Auth;
use Storage;

class SafetyInductionController extends Controller {

    public function __construct(){
        $this->storage = [
            "safety_induction" => "public/safety-induction",
        ];
    }

    public function quesioner(){
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'HSE' ],
            2 => [ 'title' => 'Safety Induction' ],
            3 => [ 'title' => 'Quesioner']
        ]);
        return view('Hse.safetyInduction.quesioner', compact('breadcrumb'));
    }

    public function templateQuesioner()
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'HSE' ],
            2 => [ 'title' => 'Safety Induction' ],
            3 => [ 'title' => 'Template Quesioner']
        ]);
        return view('Hse.safetyInduction.template', compact('breadcrumb'));
    }

    public function index2(){
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'HSE' ],
            2 => [ 'title' => 'Safety Induction' ]
        ]);
        return view('Hse.safetyInduction.index2', compact('breadcrumb'));
    }

    // rest
    public function jobRoles($deptId){

        $jobRoles = JabatanModel::where('id_dept', $deptId)
                        ->select('id','nm_jabatan')
                        ->orderBy('nm_jabatan', 'asc')
                        ->get();

        return response()->json($jobRoles);
    }

    public function employeesFromJobRoleId($jobRoleId){
        $employees = KaryawanModel::where('id_jabatan', $jobRoleId)->orderBy('nm_lengkap', 'asc')->get();
        return response()->json($employees);
    }

    // Consumes in API
    public function store(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'nik' => 'required',
                'nodok' => 'required',
                'namaPengawas' => 'required',
                'namaPelaksana' => 'required',
                'lokasi' => 'required',
                'tanggalTerbit' => 'required',
                'namaApd' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            // return response()->json($request->fileFoto2);

            $nik = $request->input('nik');
            $nikKaryawanOpt = $request->input('nikKaryawanOpt');
            $nodok = $request->input('nodok');
            $namaPengawas = $request->input('namaPengawas');
            $namaPelaksana = $request->input('namaPelaksana');
            $lokasi = $request->input('lokasi');
            $tanggalTerbit = $request->input('tanggalTerbit');
            $namaApd = $request->input('namaApd');
            $fileSuratPengantar = $request->fileSuratPengantar->store('public/safety-induction');
            $fileFormInduksi = $request->fileFormInduksi->store('public/safety-induction');
            $fileFoto1 = $request->fileFoto1 !== "null" ? $request->fileFoto1->store('public/safety-induction') : null;
            $fileFoto2 = $request->fileFoto2 !== "null" ? $request->fileFoto2->store('public/safety-induction') : null;
            $fileFoto3 = $request->fileFoto3 !== "null" ? $request->fileFoto3->store('public/safety-induction') : null;
            $fileJsa = $request->fileJsa->store('public/safety-induction');
            $filePemahamanSafety = $request->filePemahamanSafety->store('public/safety-induction');

            $jsa = HseJobSafetyAnalisis::create([
                'no_jsa' => null,
                'no_dokumen' => $nodok,
                'nama_pengawas' => $namaPengawas,
                'nama_pelaksana' => $namaPelaksana,
                'lokasi' => $lokasi,
                'tanggal_terbit' => $tanggalTerbit,
                'nama_apd' => $namaApd,
                'file_jsa' => str_replace('public/safety-induction/', "", $fileJsa),
            ]);

            $pemahamanSafety = HseTestPemahamanSafety::create([
                'nik_karyawan' => $nik,
                'no_dokumen' => $nodok,
                'file_quesioner' => str_replace('public/safety-induction/', "", $filePemahamanSafety)
            ]);

            $induksi = HseSafetyInduction::create([
                'nik_karyawan' => $nik,
                'nik_karyawan_opt' => $nikKaryawanOpt,
                'file_surat_pengantar' => str_replace('public/safety-induction/', "", $fileSuratPengantar),
                'file_form_induksi' => str_replace('public/safety-induction/', "", $fileFormInduksi),
                'file_dokumentasi_1' => str_replace('public/safety-induction/', "", $fileFoto1),
                'file_dokumentasi_2' => $fileFoto2 !== "null" ? str_replace('public/safety-induction/', "", $fileFoto2) : null,
                'file_dokumentasi_3' => $fileFoto2 !== "null" ? str_replace('public/safety-induction/', "", $fileFoto3) : null,
                'jsa_id' => $jsa->id,
                'test_pemahaman_id' => $pemahamanSafety->id,
            ]);

            if($induksi && $jsa && $pemahamanSafety){
                return response()->json([
                    'status' => 201,
                    'message' => 'Sukses'
                ], 201);
            }

        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    /**
     * show all safety induction data
     * @return Response
     */
    public function index(Request $request)
    {
        if($request->has(['tgAwal','tgAkhir'])){
            $queries = HseSafetyInduction::with('jsa', 'testPemahaman')
            ->whereNotNull('jsa_id')
            ->whereNotNull('test_pemahaman_id')
            // ->whereBetween('created_at', [$request->tgAwal, $request->tgAkhir])
            ->whereDate('created_at', '>=', $request->tgAwal)
            ->whereDate('created_at', '<=', $request->tgAkhir)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            return response()->json($queries);
        } else {

            $queries = HseSafetyInduction::with('jsa', 'testPemahaman')
            ->whereNotNull('jsa_id')
            ->whereNotNull('test_pemahaman_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            return response()->json($queries);
        }

    }

    /**
     * show safety induction data by id
     * @return Response
     */
    public function show($id)
    {
        $table = HseSafetyInduction::with('jsa', 'testPemahaman')->find($id);
        return response()->json($table);
    }

    /**
     * update safety induction data by id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {
            // return response()->json($request->all());
            $validator = Validator::make($request->all(), [
                'nik' => 'required',
                'nodok' => 'required',
                'namaPengawas' => 'required',
                'namaPelaksana' => 'required',
                'lokasi' => 'required',
                'tanggalTerbit' => 'required',
                'namaApd' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $nik = $request->input('nik');
            $nikKaryawanOpt = $request->input('nikKaryawanOpt');
            $nodok = $request->input('nodok');
            $namaPengawas = $request->input('namaPengawas');
            $namaPelaksana = $request->input('namaPelaksana');
            $lokasi = $request->input('lokasi');
            $tanggalTerbit = $request->input('tanggalTerbit');
            $namaApd = $request->input('namaApd');
            $fileSuratPengantar = $request->fileSuratPengantar->store('public/safety-induction');
            $fileFormInduksi = $request->fileFormInduksi->store('public/safety-induction');

            // $fileFoto1 = $request->fileFoto1->store('public/safety-induction');
            // $fileFoto2 = $request->fileFoto2 ? $request->fileFoto2->store('public/safety-induction') : null;
            // $fileFoto3 = $request->fileFoto3 ? $request->fileFoto3->store('public/safety-induction') : null;

            $fileFoto1 = $request->fileFoto1 !== "null" ? $request->fileFoto1->store('public/safety-induction') : null;
            $fileFoto2 = $request->fileFoto2 !== "null" ? $request->fileFoto2->store('public/safety-induction') : null;
            $fileFoto3 = $request->fileFoto3 !== "null" ? $request->fileFoto3->store('public/safety-induction') : null;

            $fileJsa = $request->fileJsa->store('public/safety-induction');
            $filePemahamanSafety = $request->filePemahamanSafety->store('public/safety-induction');

            $induksi = HseSafetyInduction::find($id);
            $induksi->nik_karyawan = $nik;
            $induksi->nik_karyawan_opt = $nikKaryawanOpt;
            $induksi->file_surat_pengantar = str_replace('public/safety-induction/', "", $fileSuratPengantar);
            // file lengkap dengan path
            // $induksi->file_surat_pengantar = $fileSuratPengantar;
            $induksi->file_form_induksi = str_replace('public/safety-induction/', "", $fileFormInduksi);
            $induksi->file_dokumentasi_1 = str_replace('public/safety-induction/', "", $fileFoto1);
            $induksi->file_dokumentasi_2 = str_replace('public/safety-induction/', "", $fileFoto2);
            $induksi->file_dokumentasi_3 = str_replace('public/safety-induction/', "", $fileFoto3);
            $induksi->save();

            $jsa = HseJobSafetyAnalisis::find($induksi->jsa_id);
            $jsa->no_dokumen = $nodok;
            $jsa->nama_pengawas = $namaPengawas;
            $jsa->nama_pelaksana = $namaPelaksana;
            $jsa->lokasi = $lokasi;
            $jsa->tanggal_terbit = $tanggalTerbit;
            $jsa->nama_apd = $namaApd;
            $jsa->file_jsa = str_replace('public/safety-induction/', "", $fileJsa);
            $jsa->save();

            $pemahamanSafety = HseTestPemahamanSafety::find($induksi->test_pemahaman_id);
            $pemahamanSafety->nik_karyawan = $nik;
            $pemahamanSafety->no_dokumen = $nodok;
            $pemahamanSafety->file_quesioner = str_replace('public/safety-induction/', "", $filePemahamanSafety);
            $pemahamanSafety->save();

            return response()->json([
                'status' => 204,
                'message' => 'Sukses'
            ], 204);

        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }

    }

    /**
     * get file by their name
     * @return Response
     */
    public function getFile($filename)
    {
        $path = storage_path('app/public/safety-induction/' . $filename);
        return response()->file($path);
        // $str = "public/safety-induction/6mYVqRX9nZHJxGcEDqHCfmGYIfWON7lCnvzPn6gw.png";
        // return response()->json(str_replace('public/safety-induction/', "", $str));
    }

    public function delete_safety_induction($id){

        try {
            $currentStorage = $this->storage['safety_induction'];
            if(Storage::exists($currentStorage)){

                $safetyId = HseSafetyInduction::find($id);
                $file_surat_pengantar = $safetyId->file_surat_pengantar;
                $file_form_induksi = $safetyId->file_form_induksi;
                $file_dokumentasi_1 = $safetyId->file_dokumentasi_1;
                $file_dokumentasi_2 = $safetyId->file_dokumentasi_2;
                $file_dokumentasi_3 = $safetyId->file_dokumentasi_3;

                $jsa = HseJobSafetyAnalisis::find($safetyId->jsa_id);
                $file_jsa = $jsa->file_jsa;

                $testPemahaman = HseTestPemahamanSafety::find($safetyId->test_pemahaman_id);
                $file_quesioner = $testPemahaman->file_quesioner;

                Storage::delete([
                    $currentStorage.'/'.$file_surat_pengantar,
                    $currentStorage.'/'.$file_form_induksi,
                    $currentStorage.'/'.$file_dokumentasi_1,
                    $currentStorage.'/'.$file_dokumentasi_2,
                    $currentStorage.'/'.$file_dokumentasi_3,
                    $currentStorage.'/'.$file_jsa,
                    $currentStorage.'/'.$file_quesioner,
                ]);

                $jsa->delete();
                $testPemahaman->delete();
                $safetyId->delete();

                return response()->json("safety induksi dgn id ".$id." telah di hapus");
            }

        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }


    }




    // public function inductions()
    // {
    //     $inductions = SafetyInduction::with('steps')->get();
    //     return response()->json($inductions);
    // }

    // public function create(Request $request)
    // {

    //     $induction_steps = [];
    //     $steps_name = ['step1','step2','step3','step4'];
    //     foreach ($request->input() as $key => $value) {
    //         if($key == "step1"){
    //             $induction = SafetyInduction::create([
    //                 'conduct_date' => $value['conductDate'],
    //                 'employee_id' => $value['employees'],
    //                 'created_by' => auth()->id()
    //             ]);
    //         } else {
    //             array_push($induction_steps, $value);
    //         }
    //     }

    //     if(!empty($induction->id))
    //     {
    //         foreach($induction_steps as $key => $value)
    //         {
    //             SafetyInductionSteps::create([
    //                 'safety_inductions_id' => $induction->id,
    //                 'name' => '-',
    //                 'docnumber' => $value['nomsurat']
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'status' => 201 ,
    //         'message' => 'sukses'
    //     ], 201);
    // }



}
