<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\FuelTruck;
use App\Models\Warehouse\FuelTruckConsumption;
use App\Models\Workshop\Equipment;
use Illuminate\Http\Request;

class FuelTruckConsumptionController extends Controller
{
    public function index(Request $request)
    {
        $fuelTruckConsumptions = FuelTruckConsumption::query()
            ->with(['fuel_truck', 'equipment', 'created_user.karyawan', 'updated_user.karyawan'])->whereHas('fuel_truck')->whereHas('equipment');
        $page = $request->has('page') ? $request->page : '';
        $fuelTruckConsumptions = $fuelTruckConsumptions->latest('id')->paginate(FuelTruckConsumption::PAGE_LIMIT);

        return view('Warehouse.fuel-truck-consumption.index', compact('fuelTruckConsumptions', 'page'));
    }

    public function add()
    {
        $fuelTrucks = FuelTruck::all();
        $equipments = Equipment::query()
            ->active()
            ->notFuelTruck()
            ->get();

        return view('Warehouse.fuel-truck-consumption.add', compact('fuelTrucks', 'equipments'));
    }

    public function store(Request $request)
    {
        if ($request->has('fuel_truck_id')) {
            foreach ($request->fuel_truck_id as $key => $value) {
                $fuelTruckConsumption = new FuelTruckConsumption();
                $fuelTruckConsumption->date = $request->date[$key];
                $fuelTruckConsumption->fuel_truck_id = $value;
                $fuelTruckConsumption->equipment_id = $request->equipment_id[$key];
                $fuelTruckConsumption->amount = $request->amount[$key];
                $fuelTruckConsumption->current_stock = 0;
                $fuelTruckConsumption->hm = $request->hm[$key];;
                $fuelTruckConsumption->km = $request->km[$key];;

                if ($fuelTruckConsumption->save()) {
                    $fuelTruckConsumption->decreaseFuelTruckStock($fuelTruckConsumption, $fuelTruckConsumption->amount);
                    $fuelTruckConsumption->update(['current_stock' => $fuelTruckConsumption->fuel_truck->stock]);
                }
            }
        }

        return redirect()->route('warehouse.fuel-truck-consumption.index');
    }

    public function edit($id)
    {
        $fuelTruckConsumption = FuelTruckConsumption::with(['equipment', 'fuel_truck'])->findOrFail($id);

        return view('Warehouse.fuel-truck-consumption.edit', compact('fuelTruckConsumption'));
    }

    public function update(Request $request, $id)
    {
        $fuelTruckConsumption = FuelTruckConsumption::with(['equipment', 'fuel_truck'])->findOrFail($id);
        $initialStock = $fuelTruckConsumption->amount;
        $fuelTruckConsumption->fill($request->all());

        if ($fuelTruckConsumption->save() && $initialStock != $request->amount) {
            $fuelTruckConsumption->increaseFuelTruckStock($fuelTruckConsumption, $initialStock);
            $fuelTruckConsumption->decreaseFuelTruckStock($fuelTruckConsumption, $fuelTruckConsumption->amount);
            $fuelTruckConsumption->update(['current_stock' => $fuelTruckConsumption->fuel_truck->stock]);
        }

        return redirect()->route('warehouse.fuel-truck-consumption.index');
    }

    public function destroy($id)
    {
        $fuelTruckConsumption = FuelTruckConsumption::findOrFail($id);
        $initialStock = $fuelTruckConsumption->amount;
        $fuelTruckConsumption->increaseFuelTruckStock($fuelTruckConsumption, $initialStock);
        $fuelTruckConsumption->delete();

        return redirect()->route('warehouse.fuel-truck-consumption.index');
    }
}
