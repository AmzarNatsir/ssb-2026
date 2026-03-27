<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateSparePartPrice;
use App\Models\HRD\KaryawanModel;
use App\Models\Warehouse\PurchasingOrder as WarehousePurchasingOrder;
use App\Repository\Warehouse\PurchasingComparison;
use App\Repository\Warehouse\PurchasingOrder;
use Illuminate\Http\Request;

class PurchasingOrderController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;
    $supplier_id = $request->has('supplier_id') ? $request->supplier_id : null;

    $purchasingOrders = (new PurchasingOrder())->list(
      array_merge(
        $request->all(),
        [
          'with' => ['supplier', 'purchasing_comparison','work_order.work_request.part_order'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["supplier_id" => $supplier_id]
        ],
      )
    );

    $purchasingComparisons = (new PurchasingComparison())->list([
      'where' => [
        'status' => \App\Models\Warehouse\PurchasingComparison::CURRENT_STATUS,
      ]
    ]);

    $suppliers = (new \App\Models\Warehouse\Supplier)->active()->pluck('name','id');

    return view('Warehouse.purchasing-order.index',
      [
        'purchasing_comparisons' => $purchasingComparisons,
        'purchasing_orders' => $purchasingOrders,
        'keyword' => $keyword,
        'suppliers' => $suppliers,
        'date_start' => $date_start,
        'date_end' => $date_end,
        'supplier_id' => $supplier_id,
        'search' => $request->has('search') ? $request->search : '',
        'page' => $request->has('page') ? $request->page : '',
        'limit' => $purchasingOrders->firstItem(),
      ]
    );
  }

  public function add(Request $request)
  {
    $purchasingComparison = new PurchasingComparison($request->purchasing_comparison_id);
    $po = WarehousePurchasingOrder::where('purchasing_comparison_id', $purchasingComparison->model->id)->with(['details'])->get();
    $excluededPartId = [];
    if($po){
      $excluededPartId = $po->map(function($item){
        return $item->details->groupBy('part_id')->keys();
      })->flatten();
    }
    $suppliers = \App\Models\Warehouse\Supplier::whereIn('id',$request->supplier_id)->get();
    $partsData = $purchasingComparison->model->details
      ->whereNotIn('part_id', $excluededPartId)
      ->whereIn('supplier_id', $suppliers->pluck('id'))
      ->groupBy('part_id')
      ->map(function($item) use($suppliers) {
        $supplier = $item->map(function($item) use ($suppliers){
          return collect([
            'id' => $item->supplier_id,
            'name' => $suppliers->where('id',$item->supplier_id)->first()->name,
            'price' => $item->price
          ]);
        });
        return collect([
          'part_id' => $item->first()->part_id,
          'part_name' => $item->first()->sparepart->part_name,
          'part_number' => $item->first()->sparepart->part_number,
          'qty' => $item->first()->qty,
          'suppliers' => $supplier
        ]);
      });
    // dd($partsData);
    $approvedBy =  KaryawanModel::all();

    return view('Warehouse.purchasing-order.add',
      [
        'purchasingComparison' => $purchasingComparison,
        'suppliers' => $suppliers,
        'approved_by' => $approvedBy,
        'partsData' => $partsData
      ]
    );
  }

  public function store(Request $request)
  {
    $po = [];
    foreach ($request->supplier_id as $key => $value) {
      $po[$value]['purchasing_comparison_id'] = $request->purchasing_comparison_id ?? null;
      $po[$value]['supplier_id'] = $value ?? null;
      $po[$value]['reference_id'] = $request->reference_id ?? null;
      $po[$value]['send_date'] = $request->send_date ?? null;
      $po[$value]['approved_by'] = $request->approved_by ?? null;
      $po[$value]['remarks'] = $request->remarks ?? null;
      $po[$value]['total_discount'] = $request->total_discount ?? 0;
      $po[$value]['subtotal'] = $request->subtotal ?? 0;
      $po[$value]['ppn'] = $request->ppn ?? 10;
      $po[$value]['additional_expense'] = $request->additional_expense ?? 0;
      $po[$value]['grand_total'] = $request->grand_total ?? 0;
      $po[$value]['part_id'][$key] = $request->part_id[$key] ?? null;
      $po[$value]['qty'][$key] = $request->qty[$key] ?? 0;
      $po[$value]['price'][$key] = $request->price[$key] ?? 0;
      $po[$value]['discount'][$key] = $request->discount[$key] ?? 0;
      $po[$value]['total'][$key] = $request->total[$key] ?? 0;
      $po[$value]['part_remarks'][$key] = $request->part_remarks[$key] ?? '';
    }
    // dd($request->all(),$po);
    foreach ($po as $key => $value) {
      $purchasingOrders[] = (new PurchasingOrder())->create(array_merge($value, ['purchasing_order_status' => 0]) );
    }

    if (count($purchasingOrders) > 0) {
      foreach ($purchasingOrders as $purchasingOrder){
        UpdateSparePartPrice::dispatch($purchasingOrder->model->id);
      }

      return redirect(route('warehouse.purchasing-order.index'));
    }
  }

  public function edit($id)
  {
    $purchasingOrder = new PurchasingOrder($id);
    $approvedBy = KaryawanModel::all();

    return view('Warehouse.purchasing-order.edit',
      [
        'purchasingOrder' => $purchasingOrder,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function update($id, Request $request)
  {
    $purchasingOrder = new PurchasingOrder($id);

    if ($purchasingOrder->update($request->all())) {
      UpdateSparePartPrice::dispatch($purchasingOrder->model->id);
      return redirect(route('warehouse.purchasing-order.index'));
    }
  }

  public function destroy($id)
  {
    $purchasingOrder = new PurchasingOrder($id);

    if ($purchasingOrder->remove()) {
      return redirect(route('warehouse.purchasing-order.index'));
    }
  }

  public function print($id)
  {
    $purchasingOrder = (new PurchasingOrder($id));

    return $purchasingOrder->print();
  }

  public function test()
  {
    $po = new PurchasingOrder();
    dd($po->generateNumber());
  }
}
