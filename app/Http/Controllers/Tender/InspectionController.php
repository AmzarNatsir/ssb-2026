<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\Inspection;
use App\Models\Hse\InspectionCheckpoint;
use App\Models\Hse\InspectionItem;
use App\Models\Hse\InspectionProperties;
use App\Models\Workshop\EquipmentCategory;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\Location;
use App\Models\HRD\KaryawanModel;
use Carbon\Carbon;
use PDF;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspectionItem = InspectionItem::with('properties.input')->get();
        $equipmentCategory = EquipmentCategory::select('id','name')->orderBy('name', 'asc')->get();
        $equipment = Equipment::with('category')->get();
        $location = Location::orderBy('location_name', 'asc')->get();
        $breadcrumb = collect([
            0 => [ 'title' => 'Dashboard' ],
            1 => [ 'title' => 'HSE' ],
            2 => [ 'title' => 'P2H' ],
            3 => [ 'title' => 'Daftar P2H']
          ]);
        
        return view('Tender.inspection.index', 
            compact(
                'inspectionItem',
                'equipmentCategory',
                'equipment',
                'location',
                'breadcrumb'
            )
        );
    }

    public function loadDataTable(Request $request)
    {        
        if($request->has(['startDate','endDate']))
        {                        
            $startDate = Carbon::parse($request->get('startDate'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse($request->get('endDate'))->format('Y-m-d')." 23:59:00";            

            $p2h = Inspection::with([
                'location' => function ($query){
                    $query->select('id','location_name');
                },
                'equipment' => function ($query){
                    $query->select('id','code','name');
                },
                'officer' => function ($query){
                    $query->with(['karyawan' => function ($query){
                        $query->select('id','nik','nm_lengkap');
                    }])->select('id','nik');
                }])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select('id','location_id','equipment_id','officer_id','assignment_no','created_at')
                ->get();            
        }

        return response()->json(['data' => $p2h ]);
    }

    public function viewAsPDF($inspectionId)
    {        
        $p2h = Inspection::where('id', $inspectionId)
            ->with([
                'location' => function ($query){
                    $query->select('id','location_name');
                }, 
                'equipment' => function ($query){
                    $query->select('id','code','name');
                },
                'officer' => function ($query){
                    $query->with(['karyawan' => function ($query){
                        $query->select('id','nik','nm_lengkap');
                    }])->select('id','nik');
                }, 'checkpoints' => function ($query){
                    $query->with(['checkpointItems' => function ($query){
                        $query->select('id','name');
                    }]);
                }])
            ->select('id','location_id','equipment_id','officer_id','assignment_no','created_at')
            ->first();
        // return response()->json([ 'data' => $p2h ]);
        $pdf = PDF::loadview('Tender.inspection.viewaspdf', compact('p2h'));
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inspectionItem = InspectionItem::with('properties.input')->get();
        // $inspectionProperties = InspectionProperties::with('item')->get();
        // dd($inspectionItem);
        return view('Tender.inspection.create', 
            compact('inspectionItem')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        
        $inspection_arr = [];
        foreach ($request->input('data') as $key => $value) {            
            
            if($key == 0){

                $inspection = Inspection::create([       
                    'inspection_checkpoint_id' => 0, 
                    'location_id' => $value['location'],
                    'equipment_id' => $value['equipment'],
                    'report_set_id' => 1,
                    'officer_id' => $value['operator'],
                    'checkpoint' => 0
                ]);
            } else {
                array_push($inspection_arr, $value);
            }

        }

        if(!empty($inspection->id)){
            // return response()->json($inspection_arr);
            foreach ($inspection_arr as $key => $value) 
            {                
                $inspectionCheckpoint = InspectionCheckpoint::create([
                    'inspection_id' => $inspection->id,
                    'inspection_item_id' => ($key + 1),
                    'properties' => $value
                ]);                
            }
        }

        // simpan ke tabel inspection
        // simpan ke inspection_checkpoint

    }

    // JSON
    // *****************************************
    public function inspectionItems()
    {
        // $inspectionItem = InspectionItem::with('properties.input')->get();
        $inspectionItem = InspectionItem::with(
            ['properties' => function ($query){
                $query->with(
                    ['input' => function ($query){
                        $query->select('id','type');
                    }])->select('id','inspection_item_id','inspection_properties_input_id','name','mandatory');
        }])->get();
        return response()->json($inspectionItem);
    }

    public function locations()
    {
        $location = Location::select(['id as key','location_name as value'])
                    ->orderBy('location_name', 'asc')
                    ->get();
        return response()->json($location);
    }

    public function equipmentCategories()
    {
        $equipmentCategories = EquipmentCategory::select(['id as key','name as value'])->orderBy('name','asc')->get();
        return response()->json($equipmentCategories);
    }

    public function equipments()
    {
        $equipments = Equipment::select([
            'id as key',
            'equipment_category_id as eqcid',
            'code as eqcode',
            'name as eqname'
        ])
        ->selectRaw('CONCAT(code," ",name) as value')
        ->orderBy('code', 'asc')->get();
        return response()->json($equipments);
    }

    public function operators()
    {
        $operators = KaryawanModel::select(['id as key','nm_lengkap as value'])->orderBy('nm_lengkap','asc')->get();
        return response()->json($operators);
    }
    // *****************************************
    // END JSON

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
