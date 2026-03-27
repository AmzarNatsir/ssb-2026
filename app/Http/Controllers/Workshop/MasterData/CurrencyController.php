<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    const ROUTE_BASE_NAME = 'warehouse.master-data.currency.';

    public function __construct()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Master Data',
                'url' => '#',
                'isActive' => false
            ],
            [
                'text' => 'Mata Uang',
                'url' => route('warehouse.master-data.currency.index'),
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
        $currencies = Currency::all();

        return view('Warehouse.master-data.currency.index', ['currencies' => $currencies]);
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->symbol = $request->symbol;

        if ($currency->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;

        if ($currency->save()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }

    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        if ($currency->delete()) {
            return redirect()->route($this->routeMethod('index'));
        }
    }
}
