<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Warehouse\Supplier;
use App\Repository\Warehouse\PurchasingComparison;
use App\Repository\Warehouse\PurchasingRequest;
use Illuminate\Http\Request;

class PurchasingComparisonController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;
    $supplier_id = $request->has('supplier_id') ? $request->supplier_id : null;

    $purchasingComparisons = (new PurchasingComparison())->list(
      array_merge(
        $request->all(),
        [
          'with' => ['purchasing_request', 'details', 'work_order.work_request.part_order'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["details.supplier_id" => $supplier_id]
        ]
      )
    );

    $purchasingRequests = (new PurchasingRequest())->list([
      'where' => [
        'status' => \App\Models\Warehouse\PurchasingRequest::CURRENT_STATUS
      ]
    ]);

    $suppliers = (new Supplier)->active()->pluck('name','id');

    return view(
      'Warehouse.purchasing-comparison.index',
      [
        'purchasing_comparisons' => $purchasingComparisons,
        'purchasing_requests' => $purchasingRequests,
        'keyword' => $keyword,
        'date_start' => $date_start,
        'date_end' => $date_end,
        'suppliers' => $suppliers,
        'supplier_id' => $supplier_id,
        'page' => $request->has('page') ? $request->page : '',
        'limit' => $purchasingComparisons->firstItem(),
      ]
    );
  }

  public function store(Request $request)
  {
    $supplierIds = implode(',', array_unique($request->supplier_id));

    $purchasingComparison = (new PurchasingComparison())->create(array_merge($request->all(), ['supplier_ids' => $supplierIds]));

    if ($purchasingComparison) {
      return redirect(route('warehouse.purchasing-comparison.index'));
    }
  }

  public function add($id)
  {
    $purchasingRequest = (new PurchasingRequest($id));
    $suppliers = (new Supplier())->active()->get();
    $approvedBy = KaryawanModel::all();

    return view(
      'Warehouse.purchasing-comparison.add-edit',
      [
        'purchasing_request' => $purchasingRequest,
        'suppliers' => $suppliers,
        'approved_by' => $approvedBy
      ]
    );
  }

  public function print($id)
  {
    $purchasingComparison = (new PurchasingComparison($id));

    return $purchasingComparison->print();
  }

  public function edit($id)
  {
    $purchasingComparison = (new PurchasingComparison($id));
    $suppliers = (new Supplier())->active()->get();
    $approvedBy =  KaryawanModel::all();;
    $purchasingRequest = (new PurchasingRequest($purchasingComparison->model->purchasing_request_id));

    return view('Warehouse.purchasing-comparison.add-edit', [
      'purchasingComparison' => $purchasingComparison,
      'purchasing_request' => $purchasingRequest,
      'suppliers' => $suppliers,
      'approved_by' => $approvedBy
    ]);
  }

  public function update($id, Request $request)
  {
    $purchasingComparison = (new PurchasingComparison($id));
    $supplierIds = implode(',', array_unique($request->supplier_id));

    if ($purchasingComparison->update(array_merge($request->all(), ['supplier_ids' => $supplierIds]))) {
      return redirect(route('warehouse.purchasing-comparison.index'));
    }
  }

  public function destroy($id)
  {
    $purchasingComparison = (new PurchasingComparison($id));

    if ($purchasingComparison->remove()) {
      return redirect(route('warehouse.purchasing-comparison.index'));
    }
  }
}
