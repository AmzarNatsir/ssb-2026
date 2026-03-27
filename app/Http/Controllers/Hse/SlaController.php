<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\HseSla;
use App\Models\Hse\MstHseSlaKategori;
use PDF;

class SlaController extends Controller
{
    public function show_audit_categories(){
        $categories = \App\Models\Hse\MstHseSlaKategori::where('is_active', 1)->get();
        return response()->json($categories);
    }

    public function create_sla(Request $request){

        $sla = HseSla::create([
            'form_number' => $request->form_number,
            'location' => $request->location,
            'audit_date' => $request->audit_date,
            'audit_start_time' => $request->audit_start_time,
            'audit_end_time' => $request->audit_end_time,
            'audit_teams' => $request->audit_teams,
            'audit_actionables' => $request->audit_actionables,
            'audit_findings' => $request->audit_findings,
            'safety_behaviors' => $request->safety_behaviors,
            'status' => $request->status,
        ]);

        return response()->json($sla);
    }

    public function update_sla(Request $request, $id){

        $sla = HseSla::find($id);
        $sla->form_number = $request->form_number;
        $sla->location = $request->location;
        $sla->audit_date = $request->audit_date;
        $sla->audit_start_time = $request->audit_start_time;
        $sla->audit_end_time = $request->audit_end_time;
        $sla->audit_teams = $request->audit_teams;
        $sla->audit_actionables = $request->audit_actionables;
        $sla->audit_findings = $request->audit_findings;
        $sla->safety_behaviors = $request->safety_behaviors;
        $sla->status = $request->status;
        $sla->save();

        return response()->json($sla);
    }

    public function show_slas(){
        $slas = \App\Models\Hse\HseSla::all();
        return response()->json($slas);
    }

    public function show_sla_form($id){
        $sla = HseSla::find($id);
        return response()->json($sla);
    }

    public function delete_sla_form($id){
        $sla = HseSla::destroy($id);
        return response()->json($sla);
    }

    public function show_pdf($id){
        $sla = HseSla::find($id);
        $categories = MstHseSlaKategori::where('is_active', 1)->get();
        $pdf = PDF::loadview('Hse.sla.pdf', compact(['sla','categories']));

        // return view('Hse.sla.pdf',
        //     compact(['sla','categories'])
        // );

        return $pdf->stream();
    }
}
