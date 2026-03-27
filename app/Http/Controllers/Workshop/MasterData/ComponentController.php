<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.component.';

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
                'url' => route('warehouse.master-data.component.index'),
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
        $components = Component::all();

        return view('Warehouse.master-data.component.index', ['components' => $components]);
    }

    public function update(Request $request, $id)
    {
        $component = Component::findOrFail($id);
        $component->name = $request->name;

        if ($component->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $component = new Component;
        $component->name = $request->name;

        if ($component->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $component = Component::findOrFail($id);
        if ($component->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
