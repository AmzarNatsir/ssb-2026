<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.division.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Divisi',
                'url' => route('warehouse.master-data.division.index'),
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
        $divisions = Division::all();

        return view('Warehouse.master-data.division.index', ['divisions' => $divisions]);
    }

    public function update(Request $request, $id)
    {
        $divisions = Division::findOrFail($id);
        $divisions->name = $request->name;

        if ($divisions->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $divisions = new Division();
        $divisions->name = $request->name;


        if ($divisions->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $divisions = Division::findOrFail($id);
        if ($divisions->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
