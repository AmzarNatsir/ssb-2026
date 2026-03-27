<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.brand.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Brand',
                'url' => route('warehouse.master-data.brand.index'),
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
        $brands = Brand::all();

        return view('Warehouse.master-data.brand.index', ['brands' => $brands]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->description = $request->description;

        if ($brand->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->description = $request->description;

        if ($brand->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
