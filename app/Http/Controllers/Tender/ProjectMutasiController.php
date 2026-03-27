<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\ProjectMutasi;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\DepartemenModel;
use Carbon\Carbon;
use PDF;

class ProjectMutasiController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Daftar Pengajuan Mutasi']
          ]);
        $activeProjects = Project::active()->get();
        return view('Tender.project_mutasi.index', compact('breadcrumb','activeProjects'));
    }

    public function loadDataTable(Request $request)
    {
        if($request->has(['project','startDate','endDate']))
        {
            $projectId = $request->get('project');
            $startDate = Carbon::parse($request->get('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->get('endDate'))->endOfDay();

            $projectMutasi = ProjectMutasi::with(
                ['project'=>function($query){
                    $query->select('id','number');
                },
                'employee' => function ($query){
                    $query->select('id','nik','nm_lengkap');
                },
                'createdBy' => function ($query){
                    $query->with(['karyawan'=>function ($q){
                        $q->select('id','nik','nm_lengkap');
                    }]);
                }])
                ->where('project_id', $projectId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->get();

            return response()->json(['data'=> $projectMutasi]);
        }
    }

    public function create()
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Form Pengajuan Mutasi']
        ]);

        $activeProjects = Project::active()->get();

        $jabatan = JabatanModel::all();

        $department = DepartemenModel::all();

        $employees = KaryawanModel::orderBy('nm_lengkap','asc')->get();

        return view('Tender.project_mutasi.create', compact('breadcrumb','activeProjects','employees','jabatan', 'department'));
    }

    public function saveForm(Request $request)
    {
        $redirectParams = [
            'route' => 'project.mutasi.index',
            'args' => [],
        ];

        try {
            // Cek apakah employee_id dan project_id sudah ada dalam data
            $existingMutasi = ProjectMutasi::where('employee_id', $request->input('employee'))
            ->where('project_id', $request->input('project'))
            ->first();

            if (!$existingMutasi) {
                $projectMutasi = ProjectMutasi::create([
                    'project_id' => $request->input('project'),
                    'employee_id' => $request->input('employee'),
                    'new_dept' => $request->input('department'),
                    'new_jabt' => $request->input('jabatan'),
                    'eff_date' => $request->input('eff_date'),
                    'ketera' => $request->input('ketera'),
                    'created_by' => auth()->id(),
                ]);
                $messages['success'] = 'Pengajuan mutasi berhasil dibuat';
            } else {
                $messages['danger'] = 'Pengajuan mutasi dengan employee dan project yang sama sudah ada.';
            }
            // dd($projectMutasi);
        } catch(\Illuminate\Database\QueryException $ex){
            $messages['danger'] = 'Error pada saat menginput Pengajuan mutasi.';
        }

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    public function printForm($idPengajuanMutasi)
    {
        $projectMutasi = ProjectMutasi::where('id', $idPengajuanMutasi)
            ->with(
                ['project'=>function($query){
                    $query->select('id','number','name');
                },
                'department' => function ($query){
                    $query->select('id','nm_dept');
                },
                'jabatan' => function ($query){
                    $query->select('id','nm_jabatan');
                },
                'employee' => function ($query){
                    $query->with(['get_departemen' => function($q){
                        $q->select('id','nm_dept');
                    },'get_jabatan'=>function($q){
                        $q->select('id','nm_jabatan');
                    }])
                    ->select('id','nik','nm_lengkap','id_jabatan','id_departemen');
                },
                'createdBy' => function ($query){
                    $query->with(['karyawan'=>function ($q){
                        $q->select('id','nik','nm_lengkap');
                    }]);
            }])
            ->get();
        $pdf = PDF::loadview('Tender.project_mutasi.cetak_form', compact('projectMutasi'));
        return $pdf->stream();
    }
}
