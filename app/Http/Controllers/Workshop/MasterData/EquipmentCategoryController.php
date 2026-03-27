<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Workshop\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipmentCategories = EquipmentCategory::all();

        return view('Workshop.master-data.equipment-category.index', [
            'equipment_categories' => $equipmentCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $equipmentCategory = new EquipmentCategory();
        $equipmentCategory->fill($request->all());

        if ($equipmentCategory->save()) {
            return redirect()->route('workshop.master-data.equipment-category.index');
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
        $equipmentCategory = EquipmentCategory::findOrFail($id);
        $equipmentCategory->fill($request->all());

        if ($equipmentCategory->save()) {
            return redirect()->route('workshop.master-data.equipment-category.index');
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
