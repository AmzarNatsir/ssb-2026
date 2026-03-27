<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\SparePart;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\MasterData\Tools;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function part_autocomplete(Request $request)
    {
        $keyword = $request->has('term') ? $request->term : '';

        $spareParts = SparePart::select('id','part_name', 'part_number', 'price', 'stock')
                    ->where('part_name', 'like', '%'.$keyword.'%')
                    ->orWhere('part_number', 'like', '%'.$keyword.'%')
                    ->limit(10)
                    ->get();

        $spareParts = $spareParts->map(function($value, $key){

            return [
                'id' => $value->id,
                'label' => $value->part_name,
                'value' => $value->part_name,
                'price' => $value->price,
                'part_number' => $value->part_number ,
                'stock' => $value->stock
            ];
        })->toArray();

        return $spareParts;
    }

    public function equipmentAutoComplete(Request $request)
    {
        $keyword = $request->has('term') ? $request->term : '';

        $equipment = Equipment::with(['location', 'project'])->select('id','name', 'code', 'serial_number', 'hm','km')
                    ->where('id', '=', $keyword)
                    ->orWhere('name', 'like', $keyword.'%')
                    ->get();

        $equipment = $equipment->map(function($value, $key){
            return [
                'id' => $value->id,
                'label' => $value->name,
                'value' => $value->name,
                'code' => $value->code,
                'serial_number' => $value->serial_number ,
                'hm' => $value->hm,
                'km' => $value->km,
                'project' => [
                    'id' => $value->project->id ?? null,
                    'name' => $value->project->name ?? null,
                ],
                'location' => [
                    'id' => $value->project->id ?? null,
                    'namme' => $value->location->name ?? null
                ]
            ];
        })->toArray();

        return $equipment;
    }

    public function toolAutoComplete(Request $request)
    {
        $keyword = $request->has('term') ? $request->term : '';

        $equipment = Tools::select('id','name', 'code', 'qty')
                    ->where('code', 'like', '%'.$keyword.'%')
                    ->orWhere('name', 'like', '%'.$keyword.'%')
                    ->limit(10)
                    ->get();

        $equipment = $equipment->map(function($value, $key){
            return [
                'id' => $value->id,
                'label' => $value->code.' - '.$value->name,
                'value' => $value->name,
                'code' => $value->code,
                'qty' => $value->qty
            ];
        })->toArray();

        return $equipment;
    }
}
