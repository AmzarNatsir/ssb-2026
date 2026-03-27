<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Repository\Warehouse\PurchasingOrder;
use App\Repository\Warehouse\Receiving;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;
    $supplier_id = $request->has('supplier_id') ? $request->supplier_id : null;

    $receivings = (new Receiving())->list(
      array_merge(
        $request->all(),
        [
          'with' => ['purchasing_order', 'received_user', 'supplier'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["supplier_id" => $supplier_id],
          'where_like' => ['invoice_number' => $keyword]
        ]
      )
    );

    $purchasingOrders = (new PurchasingOrder())->list([
      'where' => [
        'purchasing_order_status' => \App\Models\Warehouse\PurchasingOrder::PURCHASING_ORDER_STATUS_INCOMPLETE
      ]
    ]);

    $suppliers = (new \App\Models\Warehouse\Supplier)->active()->pluck('name','id');

    return view('Warehouse.receiving.index',
      [
        'purchasing_orders' => $purchasingOrders,
        'receivings' => $receivings,
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
    $approvedBy =  KaryawanModel::all();

    return view('Warehouse.receiving.add-edit',
      [
        'purchasingOrder' => $purchasingOrder,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function store(Request $request)
  {
    $receiving = (new Receiving())->create($request->all());

    if ($request->filled('issued_immediately')) {
      (new \App\Repository\Warehouse\Issued())->create( array_merge($request->all(), [
          'received_at' => now()
        ]
      ));
    }

    if ($receiving) {
      return redirect(route('warehouse.receiving.index'));
    }
  }

  public function edit($id)
  {
    $receiving = new Receiving($id);
    $approvedBy =  KaryawanModel::all();

    return view('Warehouse.receiving.add-edit',
      [
        'receiving' => $receiving,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function update($id, Request $request)
  {
    $receiving = new Receiving($id);

    if ($receiving->update($request->all())) {
      return redirect(route('warehouse.receiving.index'));
    }
  }

  public function destroy($id)
  {
    $receiving = new Receiving($id);

    if ($receiving->remove()) {
      return redirect(route('warehouse.receiving.index'));
    }
  }

  public function print($id)
  {
    $receiving = (new Receiving($id));

    return $receiving->print();
  }

  public function test()
  {
    // dd(\App\Models\Warehouse\Receiving::first()->id);
    $receiving = new Receiving(\App\Models\Warehouse\Receiving::first()->id);
    dd($receiving->model->syncPurchasingOrder());
  }
}
