<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hse\HseSafetyPatrol;

class SafetyPatrolController extends Controller {
    public function store_patrol_schedule(Request $request){
        $schedule = HseSafetyPatrol::create([
            'tgl_patroli' => $request->tgl_patroli,
            'hse_officer' => $request->hse_officer,
            'locations' => $request->locations,
        ]);

        return response()->json($schedule);
    }

    public function show_schedules(){
        $schedules = HseSafetyPatrol::all();
        return response()->json($schedules);
    }

    public function show($id){
        $schedule = HseSafetyPatrol::find($id);
        return response()->json($schedule);
    }

    public function update(Request $request, $id){
        $schedule = HseSafetyPatrol::find($id);
        $schedule->tgl_patroli = $request->tgl_patroli;
        $schedule->hse_officer = $request->hse_officer;
        $schedule->locations = $request->locations;
        $schedule->save();
        return response()->json($schedule);
    }
}
