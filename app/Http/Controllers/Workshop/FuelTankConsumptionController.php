<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\FuelTank;
use App\Models\Warehouse\FuelTankConsumption;
use Illuminate\Http\Request;

class FuelTankConsumptionController extends Controller
{
    public function index(Request $request)
    {
        $fuelTankConsumptions = FuelTankConsumption::with(['fuelTankConsumption', 'fuel_tank', 'created_user.karyawan', 'updated_user.karyawan'])->whereHas('fuel_tank')->whereHasMorph('fuelTankConsumption', [\App\Models\Workshop\Equipment::class, \App\Models\Warehouse\FuelTruck::class, \App\Models\Warehouse\FuelTank::class]);

        $fuelTankConsumptions = $fuelTankConsumptions->latest('id')->paginate(FuelTankConsumption::PAGE_LIMIT);
        $page = $request->has('page') ? $request->page : '';

        return view('Warehouse.fuel-tank-consumption.index', compact('fuelTankConsumptions', 'page'));
    }

    public function add()
    {
        $fuelTanks = FuelTank::all();

        return view('Warehouse.fuel-tank-consumption.add', compact('fuelTanks'));
    }

    public function store(Request $request)
    {
        foreach ($request->fuel_tank_id as $key => $value) {
            $fuelTankConsumption = new FuelTankConsumption();
            $fuelTankConsumption->date = $request->date[$key];
            $fuelTankConsumption->fuel_tank_id = $value;
            $fuelTankConsumption->reference_type = $request->reference_type[$key];
            $fuelTankConsumption->reference_id = $request->reference_id[$key];
            $fuelTankConsumption->amount = $request->amount[$key];
            $fuelTankConsumption->current_stock = 0;
            $fuelTankConsumption->description = $request->description[$key];
            $fuelTankConsumption->hm = $request->hm[$key];
            $fuelTankConsumption->km = $request->km[$key];
            if ($fuelTankConsumption->save()) {
                // capture changes for the current fuel tank
                $fuelTankConsumption->fuel_tank->decreaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);

                if ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTank::class) {
                    $fuelTankConsumption->fuelTankConsumption->increaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);
                } elseif ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTruck::class) {
                    $fuelTankConsumption->fuelTankConsumption->increaseFuelTruckStock($fuelTankConsumption, $fuelTankConsumption->amount);
                }

                $fuelTankConsumption->update(['current_stock' => $fuelTankConsumption->fuel_tank->stock]);
            }
        }

        return redirect()->route('warehouse.fuel-tank-consumption.index');
    }

    public function getDestinationData(Request $request)
    {
        if ($request->has('type')) {
            $selectedFuelTank = $request->selectedFuelTank;
            $destination = new $request->type;
            if ($destination instanceof \App\Models\Workshop\Equipment) {
                // get only equipment with status active
                $destinationData = $destination->active()->get();
            } elseif ($destination instanceof \App\Models\Warehouse\FuelTruck) {
                $destinationData = $destination->with('equipment')->get();
            } else {
                $destinationData = $destination->all();
            }

            $destinationData = $destinationData->map(function ($item) use ($selectedFuelTank) {
                $res['id'] = $item->id;

                if ($item instanceof \App\Models\Warehouse\FuelTank && $item->id == $selectedFuelTank) {
                    return '';
                }

                if ($item instanceof \App\Models\Workshop\Equipment) {
                    $res['name'] = $item->name;
                    $res['km'] = $item->km;
                    $res['hm'] = $item->hm;
                } elseif ($item instanceof \App\Models\Warehouse\FuelTruck) {
                    $res['name'] = $item->number;
                    $res['km'] = $item->equipment->km;
                    $res['hm'] = $item->equipment->hm;
                } else {
                    $res['name'] = $item->number;
                    $res['km'] = null;
                    $res['hm'] = null;
                }
                return $res;
            })->filter()->values();

            return response()->json($destinationData);
        }
    }

    public function edit($id)
    {
        $fuelTankConsumption = FuelTankConsumption::with('fuelTankConsumption')->findOrFail($id);

        return view('Warehouse.fuel-tank-consumption.edit', compact('fuelTankConsumption'));
    }

    public function update(Request $request, $id)
    {
        $fuelTankConsumption = FuelTankConsumption::findOrFail($id);
        $initialAmount = $fuelTankConsumption->amount;
        $fuelTankConsumption->fill($request->all());

        if ($fuelTankConsumption->save() && $initialAmount != $fuelTankConsumption->amount) {
            $fuelTankConsumption->fuel_tank->increaseFuelTankStock($fuelTankConsumption, $initialAmount);
            $fuelTankConsumption->fuel_tank->decreaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);

            if ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTank::class) {
                $fuelTankConsumption->fuelTankConsumption->decreaseFuelTankStock($fuelTankConsumption, $initialAmount);
                $fuelTankConsumption->fuelTankConsumption->increaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);
            } elseif ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTruck::class) {
                $fuelTankConsumption->fuelTankConsumption->decreaseFuelTruckStock($fuelTankConsumption, $initialAmount);
                $fuelTankConsumption->fuelTankConsumption->increaseFuelTruckStock($fuelTankConsumption, $fuelTankConsumption->amount);
            }

            $fuelTankConsumption->update(['current_stock' => $fuelTankConsumption->fuel_tank->stock]);
        }

        return redirect()->route('warehouse.fuel-tank-consumption.index');
    }

    public function destroy($id)
    {
        $fuelTankConsumption = FuelTankConsumption::findOrFail($id);

        $fuelTankConsumption->fuel_tank->increaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);
        if ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTank::class) {
            $fuelTankConsumption->fuelTankConsumption->decreaseFuelTankStock($fuelTankConsumption, $fuelTankConsumption->amount);
        } elseif ($fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTruck::class) {
            $fuelTankConsumption->fuelTankConsumption->decreaseFuelTruckStock($fuelTankConsumption, $fuelTankConsumption->amount);
        }

        $fuelTankConsumption->delete();

        return redirect()->route('warehouse.fuel-tank-consumption.index');
    }
}
