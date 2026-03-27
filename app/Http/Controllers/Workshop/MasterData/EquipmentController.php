<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Tender\Project;
use App\Models\Warehouse\Brand;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\EquipmentCategory;
use App\Models\Workshop\Location;
use App\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->has('search') ? $request->search : null;

        $equipments = Equipment::latest()->with(['brand', 'equipment_category', 'pic_user.karyawan', 'current_location']);

        if ($search) {
            $equipments->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
        }

        $equipments = $equipments->paginate(Equipment::PAGE_LIMIT);
        
        $page = $request->has('page') ? $request->page : 0;

        return view('Workshop.master-data.equipment.index', [
            'equipments' => $equipments,
            'search' => $search,
            'page' => $page, 
            
            'limit' => $equipments->firstItem()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $equipmentCategory = EquipmentCategory::all();
        $brands = Brand::all();
        $pics = User::with('karyawan')->get();
        $locations = Location::all();
        $projects = Project::all();

        return view('Workshop.master-data.equipment.add-edit', [
            'equipment_category' => $equipmentCategory,
            'brands' => $brands,
            'locations' => $locations,
            'projects' => $projects,
            'pics' => $pics
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
        $equipment = new Equipment();
        $equipment->fill($request->all());

        if ($request->exists('picture')) {
            $equipment->picture = do_upload('equipment', $request->file('picture'));
        }
        
        if ($equipment->save()) {
            if ($request->exists('attribute_name')) {
                foreach ($request->attribute_name as $key => $value) {
                    $additional_attributes = new \App\Models\Workshop\MasterData\AdditionalAttributes([
                        'name' => $request->attribute_name[$key],
                        'value' => $request->attribute_value[$key],
                        'description' => $request->attribute_description[$key]
                    ]);
                    $equipment->additional_attributes()->save($additional_attributes);
                }
            }
            return redirect()->route('workshop.master-data.equipment.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipmentCategory = EquipmentCategory::all();
        $brands = Brand::all();
        $pics = User::with('karyawan')->get();
        $locations = Location::all();
        $projects = Project::all();

        return view('Workshop.master-data.equipment.add-edit', [
            'equipment' => $equipment,
            'equipment_category' => $equipmentCategory,
            'brands' => $brands,
            'locations' => $locations,
            'pics' => $pics,
            'projects' => $projects
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
        $equipment = Equipment::findOrfail($id);
        $equipment->fill($request->all());

        if ($request->exists('picture')) {
            $equipment->picture = do_upload('equipment', $request->file('picture'));
        }
        
        if ($equipment->save()) {
            if ($request->exists('attribute_name')) {
                $equipment->additional_attributes()->delete();
                foreach ($request->attribute_name as $key => $value) {
                    $additional_attributes = new \App\Models\Workshop\MasterData\AdditionalAttributes([
                        'name' => $request->attribute_name[$key],
                        'value' => $request->attribute_value[$key],
                        'description' => $request->attribute_description[$key]
                    ]);
                    $equipment->additional_attributes()->save($additional_attributes);
                }
            }
            return redirect()->route('workshop.master-data.equipment.index');
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
}
