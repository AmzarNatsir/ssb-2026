<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Boq;
use App\Models\Tender\BoqDetail;
use App\Models\Tender\Project;
use App\Models\Workshop\EquipmentCategory;
use App\Models\Workshop\Equipment;
use Config;
use PDF;

class BoqController extends Controller
{
    public function index()
    {
    	return view('Tender.boq.index');
    }

    public function loadDataTable(Request $request){

    	if($request->has(['startDate','endDate']))
    	{
    		$startDate = $request->input('startDate');
    		$endDate = $request->input('endDate');

            $boq = Project::with(['boq','status','category','type'])->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
    	}

    	return response()->json([
    		'data' => $boq
    	]);

    }

    public function create($projectId)
    {

    	$opsiAlatBerat = Config::get("constants.alat_berat");
        $equipmentCategory = EquipmentCategory::orderBy('name', 'asc')->get();
        $equipment = Equipment::orderBy('code', 'asc')->get();
        $project = Project::find($projectId);

        return view('components.tender.boq.form',
            compact(
                'opsiAlatBerat',
                'equipmentCategory',
                'equipment',
                'projectId',
                'project'
            )
        );
    }

    public function edit($projectId)
    {

        $equipmentCategory = EquipmentCategory::orderBy('name', 'asc')->get();
        $equipment = Equipment::orderBy('code', 'asc')->get();
    	$boq = Boq::with(['detail', 'project'])->where('project_id', $projectId)->get();
        $project = Project::find($projectId);

    	return view('components.tender.boq.form_edit',
            compact(
                'boq',
                'equipmentCategory',
                'equipment',
                'projectId',
                'project'
            )
        );
    }

    public function store(Request $request)
    {
    	$boq = Boq::firstOrNew([
    		'project_id' => $request->input('project_id'),
    		'created_by' => auth()->id(),
    	]);

    	if($boq->save()){
	    	$boqDetail = BoqDetail::create([
	    		'boq_id' => $boq->id,
	    		'equipment_category_id' => $request->input('equipment_category_id'),
	    		'desc' => $request->input('desc'),
	    		'qty' => $request->input('qty'),
	    		'target' => $request->input('target'),
	    		'price' => str_replace(",", "", $request->input('price')),
                'cost' => str_replace(",", "", $request->input('cost'))
	    	]);

    		$boqDetail->save();

            return response()->json([
                'status' => 1,
                'message' => "sukses menambah item"
            ]);

    	} else {
            return response()->json([
                'status' => 0,
                'message' => "Error menambah item"
            ]);
        }
    }

    public function update(Request $request)
    {
        $redirectParams = [
            'route' => 'boq.index',
            'args' => []
    	];

    	try {
            BoqDetail::updateOrCreate(
                [ 'id' =>  $request->input('boq_detail_id')],
                [
                    'boq_id' => $request->input('boq_id'),
                    'equipment_category_id' => $request->input('equipment_list'),
                    'qty' => $request->input('qty'),
                    'target' => $request->input('target'),
                    'price' => str_replace(",", "", $request->input('price')),
                    'desc' => $request->input('desc'),
                    'cost' => str_replace(",", "", $request->input('cost'))
                ]
            );


            $messages['success'] = 'Bill of Quantity berhasil diupdate';

    	} catch(\Illuminate\Database\QueryException $ex){
    			$messages['danger'] = 'Error pada saat update Bill of Quantity.';
    	}

    	return redirect()->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    public function delete(Request $request)
    {
        try {

            if($request->has('boq_detail_id'))
            {
                BoqDetail::destroy($request->input('boq_detail_id'));
            }

            return response()->json([
                'status' => 1,
                'message' => "Berhasil menghapus item"
            ]);

        } catch(\Illuminate\Database\QueryException $ex)
        {
            return response()->json([
                'status' => 0,
                'message' => "Error menghapus item"
            ]);
        }
    }

    public function cetakPDF($projectId)
    {
    	$bill = Boq::with('detail')->where('project_id', $projectId)->get('*');
    	$pdf = PDF::loadview('Tender.boq.partials.pdf', compact('bill'));

        // untuk test output sbg blade view
        // return view('Tender.boq.partials.pdf',
        //     compact('bill')
        // );

    	return $pdf->stream();
    }
}
