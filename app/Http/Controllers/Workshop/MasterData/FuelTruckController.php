<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\FuelTruck;
use App\Models\Warehouse\FuelTruckHistory;
use App\Models\Workshop\Equipment;
use Illuminate\Http\Request;
use PDF;

class FuelTruckController extends Controller
{
    public function index()
    {
        $fuel_trucks = FuelTruck::with('equipment')->get();
        $equipments = Equipment::query()->notFuelTruck()->active()->get();
        return view('Warehouse.master-data.fuel-truck.index', compact('fuel_trucks', 'equipments'));
    }

    public function store(Request $request)
    {
        $fuelTruck = new FuelTruck();
        $fuelTruck->fill($request->all());

        if ($fuelTruck->save()) {
            FuelTruckHistory::capture($fuelTruck, $fuelTruck);
            return redirect()->route('warehouse.master-data.fuel-truck.index');
        }
    }

    public function update(Request $request, $id)
    {
        $fuelTruck = FuelTruck::findOrFail($id);
        $fuelTruckCurrentStock = $fuelTruck->stock;
        $fuelTruck->fill($request->all());

        if ($fuelTruck->save()) {
            FuelTruckHistory::capture($fuelTruck, $fuelTruck, $fuelTruckCurrentStock);
            return redirect()->route('warehouse.master-data.fuel-truck.index');
        }
    }

    public function destroy($id)
    {
        $fuelTruck = FuelTruck::findOrFail($id);

        if ($fuelTruck->delete()) {
            return redirect()->route('warehouse.master-data.fuel-truck.index');
        }
    }

    public function history($id, Request $request)
    {
        $fuelTruck = FuelTruck::findOrFail($id);

        $fuelTruckHistory = FuelTruckHistory::where('fuel_truck_id', $id);

        $dateStart = $request->filled('start') ? $request->start : null;
        $dateEnd = $request->filled('end') ? $request->end : null;

        if ($dateStart && $dateEnd) {
            $fuelTruckHistory = $fuelTruckHistory->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
        }

        $fuelTruckHistory = $fuelTruckHistory->latest()->get();

        return view('Warehouse.master-data.fuel-truck.history', [
            'fuelTruck' => $fuelTruck,
            'fuelTruckHistory' => $fuelTruckHistory
        ]);
    }

    public function historyPrint($id, Request $request)
    {
        $fuelTruck = FuelTruck::findOrFail($id);

        $fuelChanges = FuelTruckHistory::where('fuel_truck_id', $id);

        $dateStart = $request->filled('start') ? $request->start : null;
        $dateEnd = $request->filled('end') ? $request->end : null;

        if ($dateStart && $dateEnd) {
            $fuelChanges = $fuelChanges->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
        }

        $fuelChanges = $fuelChanges->latest()->get();

        $pdf = PDF::loadView('Warehouse.master-data.fuel-truck.print', [
            'fuelTruck' => $fuelTruck,
            'fuelChanges' => $fuelChanges
        ])->setPaper([5, 5, 300, 1000]);

        return $pdf->stream();
    }
}
