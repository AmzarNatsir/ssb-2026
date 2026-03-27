<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Repository\Warehouse\PartReturn;
use App\Repository\Warehouse\PurchasingOrder;
use Illuminate\Http\Request;

class PartReturnController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;
    $supplier_id = $request->has('supplier_id') ? $request->supplier_id : null;

    $partReturns = (new PartReturn())->list(
      array_merge(
        $request->all(),
        [
          'with' => ['purchasing_order', 'created_user', 'supplier'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["supplier_id" => $supplier_id]
        ]
      )
    );

    $purchasingOrders = (new PurchasingOrder())->list([
      'where' => [
        'purchasing_order_status' => \App\Models\Warehouse\PurchasingOrder::PURCHASING_ORDER_STATUS_INCOMPLETE
      ]
    ]);

    $suppliers = (new \App\Models\Warehouse\Supplier)->active()->pluck('name', 'id');

    return view(
      'Warehouse.part-return.index',
      [
        'purchasing_orders' => $purchasingOrders,
        'partReturns' => $partReturns,
        'suppliers' => $suppliers,
        'keyword' => $keyword,
        'date_start' => $date_start,
        'date_end' => $date_end,
        'supplier_id' => $supplier_id,
        'page' => $request->has('page') ? $request->page : '',
        'limit' => $purchasingOrders->firstItem(),
      ]
    );
  }

  public function add($id)
  {
    $purchasingOrder = new PurchasingOrder($id);
    $approvedBy =  KaryawanModel::all();;

    return view(
      'Warehouse.part-return.add-edit',
      [
        'purchasingOrder' => $purchasingOrder,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function store(Request $request)
  {

    $partReturn = (new PartReturn())->create(array_merge($request->all(), ['return_status' => \App\Models\Warehouse\PartReturn::RETURN_STATUS_INCOMPLETE]));

    if ($partReturn) {
      return redirect(route('warehouse.part-return.index'));
    }
  }

  public function edit($id)
  {
    $partReturn = new PartReturn($id);
    $approvedBy =  KaryawanModel::all();

    return view(
      'Warehouse.part-return.add-edit',
      [
        'receiving' => $partReturn,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function update($id, Request $request)
  {
    $partReturn = new PartReturn($id);

    if ($partReturn->update($request->all())) {
      return redirect(route('warehouse.part-return.index'));
    }
  }

  public function release($id, Request $request)
  {
    $partReturn = new PartReturn($id);

    if ($partReturn->release()) {
      return redirect(route('warehouse.part-return.index'));
    }
  }

  public function destroy($id)
  {
    $partReturn = new PartReturn($id);

    if ($partReturn->remove()) {
      return redirect(route('warehouse.part-return.index'));
    }
  }

  public function print($id)
  {
    $partReturn = (new PartReturn($id));

    return $partReturn->print();
  }

  public function test()
  {
    // dd(\App\Models\Warehouse\Receiving::first()->id);
    $partReturn = new PartReturn(\App\Models\Warehouse\Receiving::first()->id);
    dd($partReturn->model->syncPurchasingOrder());
  }
}
