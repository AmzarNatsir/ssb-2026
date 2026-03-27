<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Repository\Warehouse\FuelReceiving;
use Illuminate\Http\Request;

class FuelReceivingController extends Controller
{
    public function index(Request $request)
    {
        $fuelReceivings = (new FuelReceiving())->list( array_merge($request->all(), ['with' => ['fuel_tank']]) );

        return view('Warehouse.fuel-receiving.index',
            [
                'fuelReceivings' => $fuelReceivings,
                'search' => $request->has('search') ? $request->search : '',
                'page' => $request->has('page') ? $request->page : '',
                'limit' => $fuelReceivings->firstItem(),
            ]
        );
    }

    public function add()
    {
        $suppliers = \App\Models\Warehouse\Supplier::all();
        $fuelTanks = \App\Models\Warehouse\FuelTank::all();

        return view('Warehouse.fuel-receiving.add-edit', [
            'suppliers' => $suppliers,
            'fuel_tanks' => $fuelTanks
        ]);
    }

    public function store(Request $request)
    {
        $partReturn = (new FuelReceiving())->create($request->all());

        if ($partReturn) {
            return redirect(route('warehouse.fuel-receiving.index'));
        }
    }

    public function edit($id)
    {
        $fuelReceiving = new FuelReceiving($id);
        $suppliers = \App\Models\Warehouse\Supplier::all();
        $fuelTanks = \App\Models\Warehouse\FuelTank::all();

        return view('Warehouse.fuel-receiving.add-edit',
            [
                'fuelReceiving' => $fuelReceiving,
                'suppliers' => $suppliers,
                'fuel_tanks' => $fuelTanks
            ]
        );
    }

    public function update($id, Request $request)
    {
        $partReturn = new FuelReceiving($id);

        if ($partReturn->update($request->all())) {
            return redirect(route('warehouse.fuel-receiving.index'));
        }
    }

    public function destroy($id)
    {
        $partReturn = new FuelReceiving($id);

        if ($partReturn->remove()) {
            return redirect(route('warehouse.fuel-receiving.index'));
        }
    }

    public function print($id)
    {
        $partReturn = (new FuelReceiving($id));

        return $partReturn->print();
    }
}
