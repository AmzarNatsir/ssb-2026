<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.supplier.';

    private $service;

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Supplier',
                'url' => route('warehouse.master-data.supplier.index'),
                'isActive' => false
            ],
            [
                'text' => 'List',
                'url' => '',
                'isActive' => true
            ]
        ]);

        $this->service = new \App\Warehouse\Services\MasterData(\App\Models\Warehouse\Supplier::class);
    }

    public function index()
    {
        $suppliers = $this->service->getAll();

        return view('Warehouse.master-data.supplier.index', ['suppliers' => $suppliers]);
    }

    public function add()
    {
        return view('Warehouse.master-data.supplier.add-edit');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('Warehouse.master-data.supplier.add-edit', ['supplier' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->fill($request->all());

        if ($supplier->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $supplier = $this->service->store($request->all());

        return $this->generateResponse($supplier, 'index');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
