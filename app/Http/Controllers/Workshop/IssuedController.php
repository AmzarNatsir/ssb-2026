<?php

namespace App\Http\Controllers\Workshop;

use App\Exports\Workshop\IssuedListExport;
use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\WorkOrder;
use App\Repository\Warehouse\Issued;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IssuedController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->has('keyword') ? $request->keyword : null;
    $date_start = $request->has('date_start') ? $request->date_start : null;
    $date_end = $request->has('date_end') ? $request->date_end : null;

    $issueds = (new Issued())->list(
      array_merge(
        $request->all(),
        [
          'with' => ['received_by_user', 'created_user.karyawan', 'work_order.equipment'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where_like' => ['remarks' => $keyword, 'work_order.number' => $keyword],
        ]
      )
    );

    $work_orders = WorkOrder::with(['work_request','equipment'])->whereNotIn('id', fn($q) => $q->select('reference_id')->from('issued') )->active()->get();

    return view('Warehouse.issued.index',
      [
        'issueds' => $issueds,
        'page' => $request->has('page') ? $request->page : '',
        'limit' => $issueds->firstItem(),
        'work_orders' => $work_orders,
        'keyword' => $keyword,
        'date_start' => $date_start,
        'date_end' => $date_end,
      ]
    );
  }

  public function add(Request $request)
  {
    $receivedBy = KaryawanModel::all();
    $work_order = $request->exists('id') ? WorkOrder::with(['work_request.part_order'])->findOrFail($request->id) : null;

    return view('Warehouse.issued.add-edit',
      [
        'received_by' => $receivedBy,
        'work_order' => $work_order
      ]
    );
  }

  public function store(Request $request)
  {
    $partReturn = (new Issued())->create($request->all());

    if ($partReturn) {
      return redirect(route('warehouse.issued.index'));
    }
  }

  public function edit($id)
  {
    $issued = new Issued($id);
    $receivedBy = KaryawanModel::all();

    return view('Warehouse.issued.add-edit',
      [
        'issued' => $issued,
        'received_by' => $receivedBy
      ]
    );
  }

  public function update($id, Request $request)
  {
    $partReturn = new Issued($id);

    if ($partReturn->update($request->all())) {
      return redirect(route('warehouse.issued.index'));
    }
  }

  public function destroy($id)
  {
    $partReturn = new Issued($id);

    if ($partReturn->remove()) {
      return redirect(route('warehouse.issued.index'));
    }
  }

  public function print($id)
  {
    $partReturn = (new Issued($id));

    return $partReturn->print();
  }

  public function test()
  {
    // dd(\App\Models\Warehouse\Receiving::first()->id);
    $partReturn = new Issued(\App\Models\Warehouse\Receiving::first()->id);
    dd($partReturn->model->syncPurchasingOrder());
  }

  public function download(Request $request){
    return Excel::download(
      new IssuedListExport($request),
      'issued_list_'. time() . '.xls');
  }
}
