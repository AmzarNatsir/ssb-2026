<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\WorkHour;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\EquipmentCategory;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;
use App\Models\Tender\FulfillmentUnit;
use App\Models\Tender\ProjectMutasi;
use Carbon\Carbon;

class WorkHourController extends Controller
{
    public function index()
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Operasional Harian']
          ]);
        $activeProjects = Project::active()->get();
        $workhours = WorkHour::all();
        return view('Tender.work_hours.index', compact('breadcrumb','activeProjects','workhours'));
    }

    public function create()
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Entry Jam Kerja']
        ]);
        $activeProjects = Project::active()->get();
        $equipmentCategory = EquipmentCategory::all();
        $equipmentCategory = EquipmentCategory::all();
        $jabatan = JabatanModel::all();
        return view('Tender.work_hours.create',
            compact(
                'breadcrumb',
                'activeProjects',
                'equipmentCategory',
                'jabatan'
            )
        );
    }

    public function saveWorkHour(Request $request)
    {
        // dd(Carbon::parse($request->input('operating_hour_start'))->format('h:i a'));
        // dd($request->input());

        $redirectParams = [
            'route' => 'lho.index',
            'args' => [],
        ];

        try {
            $workHour = WorkHour::create([
                "project_id" => $request->input('project'),
                "equipment_id" => $request->input('equipment'),
                "operator_id" => $request->input('operator'),
                "user_id" => auth()->id(),
                "shift" => $request->input('shift'),
                "operating_hour_start" => $request->input('operating_hour_start'),
                "operating_hour_end" => $request->input('operating_hour_end'),
                "hm_start" => $request->input('hm_start'),
                "hm_end" => $request->input('hm_end'),
                "km_start" => $request->input('km_start'),
                "km_end" => $request->input('km_end'),
                "break_hour_start" => $request->input('break_hour_start'),
                "break_hour_end" => $request->input('break_hour_end'),
                "break_hour_total" => $request->input('break_hour_total'),
                "keterangan" => $request->input('keterangan'),
                "created_by" => auth()->id()
            ]);

            // dd($workHour);

        } catch(\Illuminate\Database\QueryException $ex){

            // dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menginput work hour.';
        }

        $messages['success'] = 'Work Hour berhasil dibuat';

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    // JSON
    public function loadLastHmByEquipment($projectId, $equipmentId)
    {
        $lastHMData = WorkHour::latest()
        ->first()
        ->where('project_id', $projectId)
        ->where('equipment_id', $equipmentId)
        ->get('hm_end');
        return response()->json($lastHMData);
    }

    public function loadOperatorDriver($projectId)
    {
        if(!empty($projectId))
        {
            $base = ProjectMutasi::with(['employee'=>function ($q){
                $q->select('id','nm_lengkap','nik');
            }])->where('project_id', $projectId)->get();
            return response()->json($base);
        }
    }

    public function loadEquipmentCategory($projectId)
    {
        if(!empty($projectId))
        {
            $fulfillments = FulfillmentUnit::with(['details'=> function ($q){
                $q->with(['equipment'=>function($q){
                    $q->select('id','equipment_category_id');
                }]);
            }])->where('project_id', $projectId)->get();

            $values = array();
            foreach ($fulfillments[0]->details as $key => $value) {
                if(!in_array($value->equipment->equipment_category_id, $values)){
                    $values[$key] = $value->equipment->equipment_category_id;
                }
            }

            $equipmentCategories = EquipmentCategory::whereIn('id', $values)->orderBy('name', 'asc')->get(['id','name']);
            return response()->json($equipmentCategories);

        }
    }

    public function loadEquipments($equipmentCategory)
    {
        if(!empty($equipmentCategory))
        {
            $equipments = Equipment::where('equipment_category_id', $equipmentCategory)->get();
            return response()->json($equipments);
        }
    }

    public function loadEmployees($jabatan)
    {
        if(!empty($jabatan))
        {
            $employees = KaryawanModel::where('id_jabatan', $jabatan)->get();
            return response()->json($employees);
        }
    }

    public function loadDatatable(Request $request)
    {
        if($request->has(['project','startDate','endDate']))
        {
            $projectId = $request->get('project');
            $startDate = Carbon::parse($request->get('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->get('endDate'))->endOfDay();

            $workhour = WorkHour::with(['project'=> function ($query){
                $query->select('id','number','name');
            },
            'equipment' => function ($query){
                // $query->select('id','code','name');
                $query->with(['equipment_category'=> function ($q){
                    $q->select('id','name');
                }])->select('id','code','name','equipment_category_id');
            },
            'operator' => function ($query){
                $query->with(['karyawan'=> function($q){
                    $q->select('id','nik','nm_lengkap');
                }]);
            }])
            ->where('project_id', $projectId)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

            return response()->json([
                'data' => $workhour
            ]);

        }
    }
    // END JSON

    public function viewAsPDF($workHourId)
    {
        $workhour = WorkHour::where('id', $workHourId)->with([
            'project'=>function ($query){
                $query->active()
                ->select('id','number');
            },'details.equipment.equipment_category','user.karyawan']
        )->get();
        $pdf = PDF::loadview('Tender.work_hours.viewaspdf', compact('workhour'));
        return $pdf->stream();
    }
}
