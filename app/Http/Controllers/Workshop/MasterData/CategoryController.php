<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.category.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Category',
                'url' => route('warehouse.master-data.category.index'),
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
        $category = Category::all();

        return view('Warehouse.master-data.category.index', ['categories' => $category]);
    }

    public function update(Request $request, $id)
    {
        $uop = Category::findOrFail($id);
        $uop->name = $request->name;
        $uop->description = $request->description;

        if ($uop->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $uop = new Category;
        $uop->name = $request->name;
        $uop->description = $request->description;

        if ($uop->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $uop = Category::findOrFail($id);
        if ($uop->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
