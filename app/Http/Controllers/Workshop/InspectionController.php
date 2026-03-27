<?php

namespace App\Http\Controllers\Workshop;

use App\Exports\InspectionExport;
use App\Exports\InspectionImportTemplate;
use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Tender\Project;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\Inspection;
use App\Models\Workshop\Location;
use Illuminate\Http\Request;
use App\Imports\InspectionImport;
use Maatwebsite\Excel\Facades\Excel;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inspections = (new Inspection())->with(['equipment', 'driver', 'project'])->search($request);
        $equipments = Equipment::all();

        $inspections = $inspections->latest('id')->paginate(Inspection::PAGE_LIMIT);
        $page = $request->has('page') ? $request->page : 0;

        return view('Workshop.inspection.index', [
            'inspections' => $inspections,
            'equipments' => $equipments,
            'page' => $page,
            'limit' => $inspections->firstItem()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = KaryawanModel::where('id_jabatan', workshop_settings('driver_position'))->get()->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->nm_lengkap];
        })->toJson(JSON_PRETTY_PRINT);

        $locations = Location::all()->toJson(JSON_PRETTY_PRINT);

        $projects = Project::all()->toJson(JSON_PRETTY_PRINT);
        $equipments = Equipment::all()->transform(function ($item) {
            return ['id' => $item->id, 'name' => $item->name, 'code' => $item->code, 'km' => $item->km, 'hm' => $item->hm];
        })->values()->toJson(JSON_PRETTY_PRINT);

        return view('Workshop.inspection.add-edit', [
            'drivers' => $drivers,
            'locations' => $locations,
            'projects' => $projects,
            'equipments' => $equipments
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
        $equipments = Equipment::whereIn('id', $request->equipment_id)->select('id', 'location_id', 'project_id')->get();

        foreach ($request->equipment_id as $key => $value) {
            $inspection = new Inspection();
            $inspection->generateNumber();
            $inspection->date = $request->date[$key];
            $inspection->equipment_id = $value;
            $inspection->project_id = $equipments->where('id', $value)->first()->project_id;
            $inspection->location_id = $equipments->where('id', $value)->first()->location_id;
            $inspection->driver_id = $request->driver_id[$key];
            $inspection->shift = $request->shift[$key];
            $inspection->km_start = $request->km_start[$key];
            $inspection->km_end = $request->km_end[$key];
            $inspection->hm_start = $request->hm_start[$key];
            $inspection->hm_end = $request->hm_end[$key];
            $inspection->operating_hour = $request->operating_hour[$key];
            $inspection->standby_hour = $request->standby_hour[$key];
            $inspection->standby_description = $request->standby_description[$key];
            $inspection->breakdown_hour = $request->breakdown_hour[$key];
            $inspection->breakdown_description = $request->breakdown_description[$key];

            $inspection->save();
            $inspection->updateEquipmentKmHm();
        }

        return redirect()->route('workshop.inspection.index');
    }

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
        $inspection = Inspection::findOrFail($id);
        $drivers = KaryawanModel::where('id_jabatan', workshop_settings('driver_position'))->get();
        $locations = Location::all();
        $projects = Location::all();
        $equipments = Equipment::all();

        return view('Workshop.inspection.add-edit', [
            'drivers' => $drivers,
            'locations' => $locations,
            'projects' => $projects,
            'equipments' => $equipments,
            'inspection' => $inspection
        ]);
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
        $inspection = Inspection::findOrFail($id);
        $inspection->fill($request->all());

        if ($inspection->save()) {
            $inspection->updateEquipmentKmHm();
            return redirect()->route('workshop.inspection.index');
        }
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

    public function download(Request $request)
    {
        return Excel::download(new InspectionExport($request), 'inspection_report_' . time() . '.xls');
    }

    public function downloadTemplate()
    {
        return Excel::download(new InspectionImportTemplate(), 'inspection_template.xls');
    }

    public function import(Request $request )
    {
        try {
            Excel::import(new InspectionImport, $request->file('inspection_import'));

            return back()->withStatus('Excel file imported succesfully');
        } catch (\Exception $th) {
            return back()->withStatus($th->getMessage());
        }
    }
}
