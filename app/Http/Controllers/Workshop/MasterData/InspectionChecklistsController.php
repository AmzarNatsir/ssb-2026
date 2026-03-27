<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Workshop\InspectionChecklistGroup;
use App\Repository\Workshop\InspectionChecklistsUpsertAction;
use Illuminate\Http\Request;

class InspectionChecklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checklistGroups = InspectionChecklistGroup::with('inspectionChecklistItems')->sortByOrder()->get();

        return view('Workshop.master-data.inspection-checklist.index', [
            'checklistGroups' => $checklistGroups
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
        $inspectionUpsertAction = new InspectionChecklistsUpsertAction($request->all()['data']);
        if ($inspectionUpsertAction->upsert()) {
            return ['status' => 'ok'];
        } else {
            return [
                'status' => 'failed',
                'messages' => implode(",", $inspectionUpsertAction->errors)
            ];
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
