<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Uop;
use Illuminate\Http\Request;

class UopController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.uop.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Uop',
                'url' => route('warehouse.master-data.uop.index'),
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
        $uops = Uop::all();

        return view('Warehouse.master-data.uop.index', ['uops' => $uops]);
    }

    public function update(Request $request, $id)
    {
        $uop = Uop::findOrFail($id);
        $uop->name = $request->name;
        $uop->description = $request->description;

        if ($uop->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $uop = new Uop;
        $uop->name = $request->name;
        $uop->description = $request->description;

        if ($uop->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $uop = Uop::findOrFail($id);
        if ($uop->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
