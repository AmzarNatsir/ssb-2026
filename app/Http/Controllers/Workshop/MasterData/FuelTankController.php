<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\FuelChanges;
use App\Models\Warehouse\FuelTank;
use Illuminate\Http\Request;
use PDF;

class FuelTankController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.fuel-tank.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Fuel Tank',
                'url' => route('warehouse.master-data.fuel-tank.index'),
                'isActive' => false
            ],
            [
                'text' => 'List',
                'url' => '',
                'isActive' => true
            ]
        ]);
    }

    public function index()
    {
        $fuelTanks = FuelTank::all();

        return view('Warehouse.master-data.fuel-tank.index', ['fuel_tanks' => $fuelTanks]);
    }

    public function update(Request $request, $id)
    {
        $fuelTank = FuelTank::findOrFail($id);
        $fuelTank->number = $request->number;
        $fuelTank->capacity = $request->capacity;
        $fuelTank->stock = $request->stock;

        $originalStock = $fuelTank->getOriginal('stock');

        if ($fuelTank->save()) {

            \App\Repository\Warehouse\FuelChanges::captureChanges([
                'reference_id' => $fuelTank->id,
                'reference' => get_class($fuelTank),
                'stock' => $originalStock,
                'updated_stock' => $fuelTank->stock,
                'fuel_tank_id' => $fuelTank->id,
                'method' => $originalStock < $fuelTank->stock ? \App\Models\Warehouse\FuelChanges::INCREASE : \App\Models\Warehouse\FuelChanges::DEDUCT
            ]);

            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $fuelTank = new FuelTank;
        $fuelTank->number = $request->number;
        $fuelTank->capacity = $request->capacity;
        $fuelTank->stock = $request->stock;

        $originalStock = 0;

        if ($fuelTank->save()) {

            \App\Repository\Warehouse\FuelChanges::captureChanges([
                'reference_id' => $fuelTank->id,
                'reference' => get_class($fuelTank),
                'stock' => $originalStock,
                'updated_stock' => $fuelTank->stock,
                'fuel_tank_id' => $fuelTank->id,
                'method' => \App\Models\Warehouse\FuelChanges::INCREASE
            ]);

            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $fuelTank = FuelTank::findOrFail($id);
        if ($fuelTank->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function history($id, Request $request)
    {
        $fuelTank = FuelTank::findOrFail($id);

        $fuelChanges = FuelChanges::where('fuel_tank_id', $id);

        $dateStart = $request->filled('start') ? $request->start : null;
        $dateEnd = $request->filled('end') ? $request->end : null;

        if ($dateStart && $dateEnd) {
            $fuelChanges = $fuelChanges->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
        }

        $fuelChanges = $fuelChanges->orderBy('id', 'desc')->get();

        return view('Warehouse.master-data.fuel-tank.history', [
            'fuelTank' => $fuelTank,
            'fuelChanges' => $fuelChanges
        ]);
    }

    public function historyPrint($id, Request $request)
    {
        $fuelTank = FuelTank::findOrFail($id);

        $fuelChanges = FuelChanges::where('fuel_tank_id', $id);

        $dateStart = $request->filled('start') ? $request->start : null;
        $dateEnd = $request->filled('end') ? $request->end : null;

        if ($dateStart && $dateEnd) {
            $fuelChanges = $fuelChanges->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
        }

        $fuelChanges = $fuelChanges->orderBy('id', 'desc')->get();

        $pdf = PDF::loadView('Warehouse.master-data.fuel-tank.print', [
            'fuelTank' => $fuelTank,
            'fuelChanges' => $fuelChanges
        ])->setPaper([5, 5, 300, 1000]);

        return $pdf->stream();
    }
}
