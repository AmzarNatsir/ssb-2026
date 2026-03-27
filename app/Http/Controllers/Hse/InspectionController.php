<?php

namespace App\Http\Controllers\Hse;

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
use App\Models\HRD\JabatanModel;

use PDF;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request){
        if($request->has(['tgAwal','tgAkhir'])){
            $queries = Inspection::with(['location','equipment','equipment.equipment_category','officer'])
            ->whereBetween('created_at', [$request->tgAwal, $request->tgAkhir])
            ->paginate(10);
            return response()->json($queries);
        } else {
            $queries = Inspection::with(['location','equipment','equipment.equipment_category','officer'])
            ->paginate(10);
            return response()->json($queries);
        }
    }

    public function inspectionItems(Request $request)
    {

        $inspectionItem = InspectionItem::with(
            ['properties' => function ($query){
                $query->with(
                    ['input' => function ($query){
                        $query->select('id','type');
                    }])->select('id','inspection_item_id','inspection_properties_input_id','name','mandatory','incl_field_keterangan');
        }])
        ->select(['id','name','equipment_category'])
        ->where(
            'equipment_category', $request->get('equipment_category')
        )->get();

        return response()->json([
            'data' => $inspectionItem
        ]);
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
        $inspectionCheckpointInserted = 0;

        foreach ($request->input('data') as $key => $value) {

            if($key == 0){

                $inspection = Inspection::create([
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
            foreach ($inspection_arr as $key => $value)
            {
                $inspectionCheckpoint = InspectionCheckpoint::create([
                    'inspection_id' => $inspection->id,
                    'inspection_item_id' => ($key + 1),
                    'properties' => $value
                ]);

                if($inspectionCheckpoint){
                    $inspectionCheckpointInserted += 1;
                }
            }
        }

        if($inspectionCheckpointInserted === count($inspection_arr)){
            return response()->json([
                "status" => "sukses",
                "message" => "berhasil menyimpan data inspection"
            ]);
        }

    }

    public function locations()
    {
        $location = Location::select(['id','location_name as label'])
                    ->orderBy('location_name', 'asc')
                    ->get();
        return response()->json([
            'data' => $location
        ]);
    }

    public function locationsP2h()
    {
        $location = Location::select(['id','location_name as name'])
                    ->orderBy('location_name', 'asc')
                    ->get();
        return response()->json([
            'data' => $location
        ]);
    }

    public function equipmentCategories(Request $request)
    {
        $equipmentCategories = EquipmentCategory::select(['id','name'])->orderBy('name','asc')->get();
        return response()->json(['data'=>$equipmentCategories]);
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
        return response()->json(['data'=>$equipments]);
    }

    public function equipmentsByCategory($equipmentCategoryId)
    {
        $queries = Equipment::select([
            'id',
            'name',
            'equipment_category_id'
        ])
        ->where('equipment_category_id','=', $equipmentCategoryId)
        ->orderBy('code','asc')->get();
        return response()->json(['data'=>$queries]);
    }

    public function operators()
    {
        $operators = KaryawanModel::select([
            'id',
            'nm_lengkap as name',
            'id_departemen as id_dept',
            'id_subdepartemen as id_subdept',
            'id_jabatan as id_jabt'
        ])
        ->where(['id_departemen' => 3, 'id_subdepartemen' => 6])->get();

        return response()->json([
            'data' => $operators
        ]);
    }

    public function karyawan()
    {
        $karyawan = KaryawanModel::selectRaw('id, CONCAT(nik," ",nm_lengkap) as label, nik, nm_lengkap, id_jabatan')
        ->orderBy('nm_lengkap','asc')->get();

        return response()->json([
            'data' => $karyawan
        ]);
    }

    public function jabatan()
    {
        $jabatan = JabatanModel::select(['id','nm_jabatan'])->get();
        return response()->json([
            'data' => $jabatan
        ]);
    }

    /**
     * display PDF
     */
    public function viewPdf($p2hId)
    {
        $p2h = Inspection::with(['checkpoints','checkpoints.checkpointItems.equipment_category','location','equipment.equipment_category','officer'])
        ->where('id', $p2hId)->get();

        $pdf = PDF::loadview('Hse.p2h.pdf', compact('p2h'));
        return $pdf->stream();
        // return response()->json($p2h);

    }
}
