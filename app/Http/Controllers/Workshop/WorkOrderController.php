<?php

namespace App\Http\Controllers\Workshop;

use App\Exports\WorkOrderExport;
use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Tender\Project;
use App\Models\Warehouse\SparePart;
use App\Models\Workshop\Location;
use App\Models\Workshop\MasterData\AdditionalAttributes;
use App\Models\Workshop\MasterData\Media;
use App\Models\Workshop\MasterData\Tools;
use App\Models\Workshop\MasterData\WorkshopPartOrder;
use App\Models\Workshop\Scrap;
use App\Models\Workshop\ToolHistory;
use App\Models\Workshop\WorkOrder;
use App\Models\Workshop\WorkRequest;
use App\Repository\Workshop\UnitInspectionsInitAction;
use App\Repository\Workshop\UnitInspectionUpsertAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class WorkOrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $work_orders = (new WorkOrder())->with(['equipment', 'work_request', 'additional_attributes', 'project', 'driver', 'location'])->search($request);
    $work_requests = (new WorkRequest())->alreadyApproved()->notInWorkOrder()->orderBy('created_at', 'desc')->get();
    $page = $request->has('page') ? $request->page : 0;
    $work_orders = $work_orders->latest('id')->paginate(WorkOrder::PAGE_LIMIT);

    return view('Workshop.work-order.index', [
      'work_orders' => $work_orders,
      'work_requests' => $work_requests,
      'page' => $page,
      'limit' => $work_orders->firstItem()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function add($id)
  {
    $work_request = WorkRequest::with(['equipment', 'driver', 'additional_attributes'])->findOrFail($id);
    $supervisor = KaryawanModel::all();
    $mechanic = $this->getMechanics()->toJson(JSON_PRETTY_PRINT);
    $projects = Project::all();

    return view('Workshop.work-order.add-edit', [
      'work_request' => $work_request,
      'supervisor' => $supervisor,
      'mechanic' => $mechanic,
      'projects' => $projects
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $id)
  {
    $work_request = WorkRequest::with(['equipment'])->findOrFail($id);
    $work_order = new WorkOrder();
    $work_order->fill($request->all());
    $work_order->work_request_id = $work_request->id;
    $work_order->driver_id = $work_request->driver_id;
    $work_order->km = $work_request->equipment->km;
    $work_order->hm = $work_request->equipment->hm;
    $work_order->equipment_id = $work_request->equipment_id;
    $work_order->status = WorkOrder::STATUS_OPEN;

    if ($work_order->save()) {
      $work_order->setEquipmentStatusToUnderMainteanance();
      $work_order->setWorkRequestStatusToWO();

      if ($request->exists('repairing_name')) {
        foreach ($request->repairing_name as $key => $value) {
          $repairingAttribute = new AdditionalAttributes();
          $repairingAttribute->name = 'work_order';
          $repairingAttribute->value = $value;
          $repairingAttribute->description = isset($request->repairing_remarks[$key]) ? $request->repairing_remarks[$key] : '';

          $work_order->additional_attributes()->save($repairingAttribute);
        }
      }

      if ($request->exists('picture')) {
        foreach ($request->file('picture') as $key => $value) {
          $media = new Media();
          $media->file = do_upload('work_request', $value);

          $work_order->media()->save($media);
        }
      }

      if ($request->exists('part_id')) {
        $work_request->part_order()->delete();
        foreach ($request->part_id as $key => $value) {
          $part_order = new WorkshopPartOrder();
          $part_order->part_id = $value;
          $part_order->qty = $request->part_qty[$key];
          $part_order->description = $request->part_description[$key];
          $part_order->status = isset($request->part_status[$key]) ? $request->part_status[$key] : 0;
          $work_request->part_order()->save($part_order);
        }
      }

      if ($work_request->part_order->where('status', 0)->count() > 0) {
        $this->sendPartRequestNotification($work_order);
      }

      return redirect()->route('workshop.work-order.index');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $work_order = WorkOrder::with(['additional_attributes', 'tools.missings.details', 'tools.details.tools'])->findOrFail($id);

    $work_request = $work_order->work_request()->with(['equipment', 'driver', 'additional_attributes', 'media', 'part_order.sparepart'])->first();
    $supervisor = KaryawanModel::all();
    $mechanic = $supervisor->where('id_jabatan', workshop_settings('mechanic_position'))->transform(function ($item) {
      return ['id' => $item->id, 'name' => $item->nm_lengkap];
    })->values()->toJson(JSON_PRETTY_PRINT);
    $projects = Project::all();

    return view('Workshop.work-order.add-edit', [
      'work_order' => $work_order,
      'work_request' => $work_request,
      'supervisor' => $supervisor,
      'mechanic' => $mechanic,
      'projects' => $projects
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $work_order = WorkOrder::findOrFail($id);
    $work_request = $work_order->work_request()->with(['equipment'])->first();
    $work_order->fill($request->all());
    $work_order->work_request_id = $work_request->id;
    $work_order->driver_id = $work_request->driver_id;
    $work_order->km = $work_request->equipment->km;
    $work_order->hm = $work_request->equipment->hm;
    $work_order->equipment_id = $work_request->equipment_id;

    if ($work_order->save()) {
      $work_order->setEquipmentStatusToUnderMainteanance();
      $work_order->setWorkRequestStatusToWO();

      if ($request->exists('repairing_name')) {
        $work_order->additional_attributes()->delete();
        foreach ($request->repairing_name as $key => $value) {
          $repairingAttribute = new AdditionalAttributes();
          $repairingAttribute->name = 'work_order';
          $repairingAttribute->value = $value;
          $repairingAttribute->description = isset($request->repairing_remarks[$key]) ? $request->repairing_remarks[$key] : '';

          $work_order->additional_attributes()->save($repairingAttribute);
        }
      }

      if ($request->exists('picture')) {
        foreach ($request->file('picture') as $key => $value) {
          $media = new Media();
          $media->file = do_upload('work_request', $value);

          $work_order->media()->save($media);
        }
      }

      if ($request->exists('part_id')) {
        $work_request->part_order()->delete();
        foreach ($request->part_id as $key => $value) {
          $part_order = new WorkshopPartOrder();
          $part_order->part_id = $value;
          $part_order->qty = $request->part_qty[$key];
          $part_order->description = $request->part_description[$key];
          $part_order->status = isset($request->part_status[$key]) ? $request->part_status[$key] : 0;
          $work_request->part_order()->save($part_order);
        }
      }

      if ($work_request->part_order->where('status', 0)->count() > 0) {
        $this->sendPartRequestNotification($work_order);
      }

      return redirect()->route('workshop.work-order.index');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function delete($id)
  {
    $workOrder = WorkOrder::findOrFail($id);
    foreach ($workOrder->media as $key => $value) {
      $value->delete();
    }

    $workOrder->work_request->update(['status' => 1]);
    $workOrder->delete();

    return redirect()->route('worksop.work-request.index');
  }

  public function print($id)
  {
    $work_order = WorkOrder::with(['equipment', 'work_request', 'additional_attributes'])->findOrFail($id);
    $pdf = PDF::loadView('Workshop.work-order.print', [
      'work_order' => $work_order
    ]);
    return $pdf->stream();

    return view('Workshop.work-order.print', [
      'work_order' => $work_order
    ]);
  }

  public function download(Request $request)
  {
    return Excel::download(new WorkOrderExport($request), 'work_order_' . time() . '.xls');
  }

  public function complete($id)
  {
    $workOrder = WorkOrder::findOrFail(Crypt::decryptString($id));
    return view('Workshop.work-order.complete', compact('workOrder'));
  }

  public function completed(Request $request, $id)
  {
    $workOrder = WorkOrder::findOrFail($id);
    $partIds = $request->filled('part_id') ? collect($request->part_id) : null;
    $toolIds = $request->filled(('tools_id')) ? $request->tools_id : null;
    $toolQty = $request->filled(('tools_qty')) ? $request->tools_qty : null;

    $parts = $partIds ? SparePart::whereIn('id', $partIds->unique())->get() : null;
    $partWeights =  $request->filled('part_weight') ? $request->part_weight : null;
    $flagWarehouse = $request->filled('flag_warehouse') ? $request->flag_warehouse : null;
    // try {

    if ($partIds) {
      $data = $partIds->map(function ($item, $key) use ($partWeights, $flagWarehouse) {
        if ($flagWarehouse && in_array($key, $flagWarehouse)) {
          return [
            'warehouse' => [
              'part_id' => $item,
              'weight' => $partWeights[$key]
            ]
          ];
        } else {
          return [
            'scrap' => [
              'part_id' => $item,
              'weight' => $partWeights[$key]
            ]
          ];
        }
      })->groupBy(function ($val) {
        return key($val);
      });

      if (isset($data['scrap'])) {
        $scrap = $data['scrap']->flatten(1)->groupBy('part_id')->map(function ($val, $key) use ($parts, $workOrder) {
          $selectedPart = $parts->where('id', $key)->first();
          $scrap = new Scrap();
          $scrap->name = $selectedPart->part_name;
          $scrap->number = $selectedPart->part_number;
          $scrap->brand_id = $selectedPart->brand_id;
          $scrap->uop_id = $selectedPart->uop_id;
          $scrap->qty = count($val);
          $scrap->weight = $val->sum('weight');
          $scrap->source_type = WorkOrder::class;
          $scrap->source_id = $workOrder->id;
          return $scrap;
        });

        $this->processScrap($scrap);
      }

      if (isset($data['warehouse'])) {
        $warehouse = $data['warehouse']->flatten(1)->groupBy('part_id')->map(function ($val, $key) use ($parts, $workOrder) {
          $selectedPart = $parts->where('id', $key)->first();
          $sparepart = new SparePart();
          $sparepart->fill($selectedPart->toArray());
          $sparepart->part_number = $selectedPart->part_number . '-SCRAP';
          $sparepart->part_name = $selectedPart->part_name . '-SCRAP';
          $sparepart->interchange = 'SCRAPPED FROM WO(' . $workOrder->number . ')';
          $sparepart->stock = count($val);
          $sparepart->weight = $val->sum('weight');
          $sparepart->price = 0;
          $sparepart->min_stock = 0;
          $sparepart->max_stock = count($val);
          return $sparepart;
        });
        $this->processWarehouse($warehouse, $workOrder);
      }
    }

    if ($toolIds) {
      $this->processTools($toolIds, $toolQty, $workOrder);
    }

    $workOrder->complete();

    $workOrder->unitInspection->update(["status" => 1]);
    return redirect()->route('workshop.work-order.index');

    // } catch (\Throwable $th) {
    //     return redirect()->route('workshop.work-order.index');
    // }

  }

  private function processScrap($scraps)
  {
    foreach ($scraps as $scrap) {
      $scrap->save();
    }
  }

  private function processWarehouse($spareParts, $work_order)
  {
    foreach ($spareParts as $sparepart) {
      $sparepart->save();
    }
  }

  private function processTools($toolIds, $toolQty, $work_order)
  {
    if (!$toolIds || !$toolQty) {
      return false;
    }
    $tools = Tools::whereIn('id', $toolIds)->get();

    foreach ($toolIds as $key => $value) {
      $selectedTools = $tools->where('id', $value)->first();
      $originalStock = $selectedTools->qty;
      $selectedTools->qty = $selectedTools->qty + $toolQty[$key];
      $selectedTools->save();

      ToolHistory::capture($work_order->tools, $selectedTools, $originalStock);
    }

    $work_order->tools->complete();
  }

  public function deleteImage(Request $request)
  {
    $image = Media::findOrFail($request->id);
    $image->delete();

    return ['status' => 'ok'];
  }

  private function sendPartRequestNotification($resource)
  {
    try {
      $users = $users = \App\User::whereHas('roles.permissions', function ($q) {
        $q->where('name', 'warehouse-spare_part.purchasing_request.create');
      })->get();
      foreach ($users as $key => $user) {
        $message = 'Ada pesanan spare part untuk Work Order No: ' . $resource->number;
        $user->notify(new \App\Notifications\SparePartRequested($message));
      }
    } catch (\Exception $e) {
      return false;
    }
  }

  public function showInspection($id){
    $workOrder      = WorkOrder::with('equipment.equipment_category')->findOrFail($id);
    $unitInspection = (new UnitInspectionsInitAction($workOrder))->unitInspection;
    $mechanics      = $this->getMechanics();
    $locations      = Location::get();

    return view('Workshop.work-order.show-unit-inspection', compact('unitInspection', 'workOrder', 'mechanics', 'locations'));
  }

  public function storeInspection(Request $request, $id)
  {
    $unitInspection = WorkOrder::findOrFail($id)->unitInspection;
    $unitInspectionAction = new UnitInspectionUpsertAction($unitInspection, $request->all());

    if ($unitInspectionAction->upsert()){
      return redirect()->route('workshop.work-order.index')->with('success', 'Unit Inspection Successfully Submitted');
    } else{
      return redirect()->route('workshop.work-order.index')->with('error', $unitInspectionAction->errors);
    }
  }

  public function printInspection($id)
  {
      $workOrder = WorkOrder::with('unitInspection')->findOrFail($id);
      $unitInspection = $workOrder->unitInspection;
      $pdf = PDF::loadView('Workshop.work-order.print-inspection', [
        'unitInspection' => $unitInspection,
        'workOrder' => $workOrder
      ]);
      return $pdf->stream();

      return view('Workshop.work-order.print-inspection', compact('unitInspection','workOrder'));
  }

  public function resetInspection($id)
  {
    $workOrder = WorkOrder::with('unitInspection')->findOrFail($id);
    $workOrder->unitInspection->update(["checklists" => $workOrder->unitInspection->buildChecklists()]);

    return redirect()->route('workshop.work-order.show-inspection', ['id'=>$id]);
  }

  private function getMechanics()
  {
    return KaryawanModel::where('id_jabatan', workshop_settings('mechanic_position'))->get()->transform(function ($item) {
      return ['id' => $item->id, 'name' => $item->nm_lengkap];
    })->values();
  }
}
