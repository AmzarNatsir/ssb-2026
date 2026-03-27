<?php

namespace App\Http\Controllers\Workshop;

use App\Exports\Workshop\PurchasingRequestListExport;
use App\Http\Controllers\Controller;
use App\Models\Workshop\WorkOrder;
use App\Repository\Warehouse\PurchasingRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PurchasingRequestController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $request_type = $request->has('request_type') ? $request->request_type : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;

    $purchasingRequests = (new PurchasingRequest())->list(
      array_merge($request->all(),[
          'with' => ['details', 'work_order.work_request.part_order'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["purchasing_type" => $request_type]
        ]
      ));

    $work_orders = WorkOrder::with(
      [
        'work_request.part_order' => function($q){
          $q->where('status','!=', 1);
        },
        'equipment'
      ]
    )->active()->latest()->get()->reject(function($v, $k){
      return $v->work_request->part_order->isEmpty();
    });

    return view('Warehouse.purchasing-request.index',
      [
        'purchasing_requests' => $purchasingRequests,
        'page' => $request->has('page') ? $request->page : '',
        'work_orders' => $work_orders,
        'limit' => $purchasingRequests->firstItem(),
        'keyword' => $keyword,
        'date_start' => $date_start,
        'date_end' => $date_end,
        'request_type' => $request_type
      ]
    );
  }

  public function add(Request $request)
  {
    $type = $request->type ?? 1;

    if ($type == 1) {
      return view('Warehouse.purchasing-request.add-edit',
        [
          'purchasingType' => $type,
          'work_order' => WorkOrder::with(['equipment','work_request.part_order.sparepart'])->findOrFail($request->id)
        ]);
    } else {
      return view('Warehouse.purchasing-request.add-edit',
        [
          'purchasingType' => $type
        ]
      );
    }
  }

  public function store(Request $request)
  {
    $attributes = $request->all();

    $purchasingRequests = (new PurchasingRequest())->create($attributes);

    if ($purchasingRequests) {
      return redirect(route('warehouse.purchasing-request.index'));
    }

  }

  public function edit($id)
  {
    $purchasingRequest = (new PurchasingRequest($id));

    return view('Warehouse.purchasing-request.add-edit', [
      'purchasingRequest' => $purchasingRequest
    ]);
  }

  public function update($id, Request $request)
  {
    $purchasingRequest = (new PurchasingRequest($id));

    if ($purchasingRequest->update($request->all()) ) {
      return redirect(route('warehouse.purchasing-request.index'));
    }
  }

  public function destroy($id)
  {
    $purchasingRequest = (new PurchasingRequest($id));

    if ($purchasingRequest->remove()) {
      return redirect()->route('warehouse.purchasing-request.index');
    }
  }


  public function print($id)
  {
    $purchasingRequests = (new PurchasingRequest($id));

    return $purchasingRequests->print();
  }

  public function test()
  {
    $purchasingRequests = (new PurchasingRequest());
    dd($purchasingRequests->getLastNumber());
  }

  public function download(Request $request){
    return Excel::download(
      new PurchasingRequestListExport($request),
      'purchasing_request_list'. time() . '.xls');
  }
}
