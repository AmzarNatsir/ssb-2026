<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Boq;
use App\Models\Tender\BoqDetail;
use App\Models\Tender\Project;
use App\Models\Tender\FulfillmentUnit;
use App\Models\Tender\FulfillmentUnitDetail;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\EquipmentCategory;
use Carbon\Carbon;
use PDF;

class UnitFulfillmentController extends Controller
{
    public function index()
    {
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Pemenuhan Unit']
          ]);
        $activeProjects = Project::active()->get();
        return view('Tender.unit_fulfillment.index', compact('breadcrumb','activeProjects'));
    }

    public function loadDataTable(Request $request)
    {
        // dd($request->get('startDate'));
        if($request->has(['project','startDate','endDate']))
        {
            $projectId = $request->get('project');
            $startDate = Carbon::parse($request->get('startDate'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse($request->get('endDate'))->format('Y-m-d')." 23:59:00";
            // dd($startDate);

            $fulfillmentList = FulfillmentUnit::with([
                'project' => function ($query){
                    $query->active()
                    ->select('id','number');
                    // ->whereBetween('created_at', [$startDate, $endDate])
                },
                'user' => function ($query){
                    $query->with(['karyawan'=> function($q){
                        $q->select('id','nik','nm_lengkap');
                    }]);
                }
            ])
            ->whereBetween('created_at', [$startDate, $endDate])
            // ->groupBy(['project_id','user_id','created_at','updated_at'])
            // ->map(function ($group) {
            //         // Pluck the FulfillmentUnit IDs within each group
            //         return $group->pluck('id');
            //     })
            ->get();
            return response()->json(['data' => $fulfillmentList ]);
        }
    }

    public function create()
    {
        $activeProjects = Project::active()->get();
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'Project Management' ],
            2 => [ 'title' => 'Project' ],
            3 => [ 'title' => 'Pemenuhan Unit'],
            4 => [ 'title' => 'Create Unit Fulfillment']
          ]);

        return view('Tender.unit_fulfillment.create', compact('breadcrumb','activeProjects'));
    }

    // refer to the Project Bill of Quantity
    public function loadEquipmentCategoriesFromBoq($project)
    {
        if(!empty($project))
        {

            $equipmentCategoriesFromBoq = EquipmentCategory::with('equipments')->get();
            // $equipmentCategoriesFromBoq = Project::with(['boq.detail'])->where('id', $project)->select('id','number')->get();
            return response()->json($equipmentCategoriesFromBoq);

        }
    }

    public function save(Request $request)
    {
        $redirectParams = [
            'route' => 'fulfillment.index',
            'args' => [],
        ];

        if(count($request->input()) > 2){

            try {
                $fulfillment = FulfillmentUnit::create([
                    'project_id' => $request->input('project_id'),
                    'user_id' => auth()->id()
                ]);

                if($fulfillment)
                {
                    foreach($request->input('checked-unit') as $key => $value)
                    {
                        FulfillmentUnitDetail::create([
                            'fulfillment_unit_id' => $fulfillment->id,
                            'equipment_id' => $key
                        ]);
                    }
                }

                $messages['success'] = 'Fulfillment unit berhasil disimpan';
            } catch(\Illuminate\Database\QueryException $ex)
            {
                $messages['danger'] = 'Error pada saat menginput fulfillment.';
            }

        } else {
            $messages['danger'] = 'Belum melakukan input checklist fulfillment.';
        }

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    public function viewAsPDF($fulfillmentId)
    {
        $fulfillment = FulfillmentUnit::where('id', $fulfillmentId)->with([
            'project'=>function ($query){
                $query->active()
                ->select('id','number');
            },'details.equipment.equipment_category','user.karyawan']
        )->get();
        $pdf = PDF::loadview('Tender.unit_fulfillment.viewaspdf', compact('fulfillment'));
        return $pdf->stream();
    }
}
