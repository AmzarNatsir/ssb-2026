<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Category;
use App\Models\Warehouse\SparePart;
use App\Models\Warehouse\Uop;
use App\Repository\Warehouse\StockChanges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SparePartController extends Controller
{
  const ROUTE_BASE_NAME = 'warehouse.master-data.spare-part.';

  public function __construct()
  {
    view()->share('breadCrumb', [
      [
        'text' => 'Master Data',
        'url' => '#',
        'isActive' => false
      ],
      [
        'text' => 'Spare Part',
        'url' => route('warehouse.master-data.spare-part.index'),
        'isActive' => false
      ],
      [
        'text' => 'List',
        'url' => '',
        'isActive' => true
      ]
    ]);
  }

  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $category = $request->has('category') ? $request->category : null;
    $brand = $request->has('brand') ? $request->brand : null;
    $rack = $request->has('rack') ? $request->rack : null;

    $spareParts = SparePart::latest()->with(['uop', 'brand', 'category']);

    if ($keyword) {
      $spareParts->where('part_name', 'like', '%' . $keyword . '%')
        ->orWhere('part_number', 'like', '%' . $keyword . '%');
    }

    if ($category) {
      $spareParts->where('category_id', $category);
    }

    if ($brand){
      $spareParts->where('brand_id', $brand);
    }

    if ($rack){
      $spareParts->where('rack', $rack);
    }

    $spareParts = $spareParts->paginate(SparePart::PAGE_LIMIT);
    $page = $request->has('page') ? $request->page : 0;
    $categories = Category::all();
    $brands = Brand::all();
    $racks = DB::table('spare_part')->distinct()->get(['rack']);

    return view(
      'Warehouse.master-data.spare-part.index',
      [
        'spareParts' => $spareParts,
        'keyword' => $keyword,
        'page' => $page,
        'limit' => $spareParts->firstItem(),
        'categories' => $categories,
        'brands' => $brands,
        'racks' => $racks,
        'selCategory' => $category,
        'selBrand' => $brand,
        'selRack' => $rack
      ]
    );
  }

  public function add()
  {
    view()->share('breadCrumb', [
      [
        'text' => 'Master Data',
        'url' => '#',
        'isActive' => false
      ],
      [
        'text' => 'Spare Part',
        'url' => route('warehouse.master-data.spare-part.index'),
        'isActive' => false
      ],
      [
        'text' => 'Add',
        'url' => '',
        'isActive' => true
      ]
    ]);

    $brands = Brand::all();

    $uops = Uop::all();

    $categories = Category::all();

    return view('Warehouse.master-data.spare-part.add-edit', [
      'brands' => $brands,
      'uops' => $uops,
      'categories' => $categories
    ]);
  }

  public function store(Request $request)
  {
    $sparePart = new SparePart;
    $sparePart->fill($request->all());

    if ($sparePart->save()) {
      return redirect()->route($this->routeMethod('index'));
    }
  }

  public function edit($id)
  {
    view()->share('breadCrumb', [
      [
        'text' => 'Master Data',
        'url' => '#',
        'isActive' => false
      ],
      [
        'text' => 'Spare Part',
        'url' => route('warehouse.master-data.spare-part.index'),
        'isActive' => false
      ],
      [
        'text' => 'Edit',
        'url' => '',
        'isActive' => true
      ]
    ]);

    $sparePart = SparePart::findOrFail($id);

    $brands = Brand::all();

    $uops = Uop::all();

    $categories = Category::all();

    return view('Warehouse.master-data.spare-part.add-edit', [
      'brands' => $brands,
      'uops' => $uops,
      'categories' => $categories,
      'sparePart' => $sparePart
    ]);
  }

  public function update(Request $request, $id)
  {
    $sparePart = SparePart::findOrFail($id);

    $originalStock = $sparePart->stock;

    $sparePart->fill($request->all());

    if ($sparePart->save()) {

      if ($sparePart->stock != $originalStock) {

        if ($sparePart->stock > $originalStock) {

          $method = \App\Models\Warehouse\StockChanges::INCREASE;

        } elseif ($sparePart->stock < $originalStock) {

          $method = \App\Models\Warehouse\StockChanges::DEDUCT;
        }

        // if ($sparePart->stock != $originalStock) {
        StockChanges::captureChanges([
          'spare_part' => $sparePart,
          'reference' => get_class($sparePart),
          'method' =>  $method,
          'stock' => $originalStock,
          'updated_stock' => $sparePart->stock,
          'reference_id' => $sparePart->id
        ]);
        // }

      }

      return redirect()->route($this->routeMethod('index'));
    }
  }

  public function destroy($id)
  {
    $sparePart = SparePart::findOrFail($id);
    if ($sparePart->delete()) {
      return redirect()->route($this->routeMethod('index'));
    }
  }

  public function print(Request $request)
  {
    $search = $request->has('search') ? $request->search : null;

    $spareParts = SparePart::latest()->with(['uop', 'brand', 'category']);

    if ($search) {
      $spareParts->where('part_name', 'like', '%' . $search . '%')
        ->orWhere('part_number', 'like', '%' . $search . '%');
    }

    $spareParts = $spareParts->paginate(SparePart::PAGE_LIMIT);

    $page = $request->has('page') ? $request->page : 0;

    $pdf = PDF::loadView('Warehouse.master-data.spare-part.print-all', [
      'sparePart' => $spareParts
    ]);
    return $pdf->stream();
  }

  public function autocomplete(Request $request)
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

  public function stockCard($id, Request $request)
  {
    $sparePart = SparePart::findOrFail($id);
    $stockChanges = \App\Models\Warehouse\StockChanges::with(['user.karyawan'])->where('spare_part_id', $id)->orderBy('id');

    $dateStart = $request->filled('start') ? $request->start : null;
    $dateEnd = $request->filled('end') ? $request->end : null;

    if ($dateStart && $dateEnd) {
      $stockChanges = $stockChanges->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
    }

    $stockChanges = $stockChanges->get();
    // dd($stockChanges);
    return view('Warehouse.master-data.spare-part.stock-card', [
      'sparePart' => $sparePart,
      'stockChanges' => $stockChanges
    ]);
  }

  public function stockCardPrint($id, Request $request)
  {
    $sparePart = SparePart::findOrFail($id);
    $stockChanges = \App\Models\Warehouse\StockChanges::where('spare_part_id', $id)->orderBy('id');

    $dateStart = $request->filled('start') ? $request->start : null;
    $dateEnd = $request->filled('end') ? $request->end : null;

    if ($dateStart && $dateEnd) {
      $stockChanges = $stockChanges->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateEnd);
    }

    $stockChanges = $stockChanges->get();

    $pdf = PDF::loadView('Warehouse.master-data.spare-part.print', [
      'sparePart' => $sparePart,
      'stockChanges' => $stockChanges
    ])->setPaper([5,5,300,1000]);
    return $pdf->stream();
  }
}
