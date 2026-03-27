<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Workshop\MasterData\ToolCategory;
use Illuminate\Http\Request;

class ToolsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toolCategories = ToolCategory::all();

        return view('Workshop.master-data.tool-category.index', [
            'tool_categories' => $toolCategories
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
        $toolCategory = new ToolCategory();
        $toolCategory->name = $request->name;

        if ($toolCategory->save()) {
            return redirect(route('workshop.master-data.tools-category.index'));
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
        $toolCategory = ToolCategory::findOrFail($id);
        $toolCategory->name = $request->name;

        if ($toolCategory->save()) {
            return redirect(route('workshop.master-data.tools-category.index'));
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
        $toolCategory = ToolCategory::findOrFail($id);

        if ($toolCategory->delete()) {
            return redirect(route('workshop.master-data.tools-category.index'));
        }
    }
}
