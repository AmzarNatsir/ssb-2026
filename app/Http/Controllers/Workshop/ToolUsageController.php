<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\ToolMissing;
use App\Models\Workshop\ToolMissingItems;
use App\Models\Workshop\ToolUsage;
use App\Models\Workshop\ToolUsageItems;
use App\Models\Workshop\WorkOrder;
use Illuminate\Http\Request;
use PDF;

class ToolUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tool_usages = ToolUsage::with(['toolable'])->latest();
        $work_orders = WorkOrder::with(['work_request','equipment'])->active()->notInTools()->get();
        $tool_usages = $tool_usages->paginate(ToolUsage::PAGE_LIMIT);

        $page = $request->has('page') ? $request->page : 0;

        return view('Workshop.tool-usage.index', [
            'tool_usages' => $tool_usages,
            'work_orders' => $work_orders,
            'page' => $page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        $work_order = WorkOrder::findOrFail($id);

        return view('Workshop.tool-usage.add-edit', compact('work_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $work_order = WorkOrder::findOrFail($id);
        $tool_usage = new ToolUsage();
        $tool_usage->status = ToolUsage::STATUS_OPEN;
        $work_order->tools()->save($tool_usage);

        foreach ($request->part_id as $key => $value) {
            $detail = new ToolUsageItems();
            $detail->tools_id = $value;
            $detail->qty = $request->qty[$key];
            $detail->description = $request->description[$key];

            $tool_usage->details()->save($detail);
        }

        $tool_usage->decreaseToolsStock();

        return redirect()->route('workshop.tool-usage.index');

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
        $tool_usage = ToolUsage::with(['details.tools'])->findOrFail($id);
        $work_order = WorkOrder::findOrFail($tool_usage->reference_id);

        return view('Workshop.tool-usage.add-edit', compact('work_order','tool_usage'));
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
        $tool_usage = ToolUsage::findOrFail($id);
        $tool_usage->increaseToolsStock();
        $tool_usage->details()->delete();

        foreach ($request->part_id as $key => $value) {
            $detail = new ToolUsageItems();
            $detail->tools_id = $value;
            $detail->qty = $request->qty[$key];
            $detail->description = $request->description[$key];

            $tool_usage->details()->save($detail);
        }
        $tool_usage->decreaseToolsStock();

        return redirect()->route('workshop.tool-usage.index');
    }

    public function missing($id)
    {
        $tool_usage = ToolUsage::with('details.tools')->findOrFail($id);
        $users = KaryawanModel::where('id_jabatan', workshop_settings('mechanic_position'))->get();

        return view('Workshop.tool-usage.missing', compact('tool_usage', 'users'));
    }

    public function storeMissing(Request $request, $id)
    {
        $toolMissing = new ToolMissing([
            'tool_usage_id' => $id,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'reason' => $request->reason
        ]);

        if ($toolMissing->save()) {
            foreach ($request->part_id as $key => $value) {
                $item = new ToolMissingItems();
                $item->tools_id = $value;
                $item->qty = $request->qty[$key];

                $toolMissing->details()->save($item);
            }

            $toolMissing->decreaseToolsStock(false);

            return redirect()->route('workshop.tool-usage.index');
        }

    }

    public function printMissing($id)
    {
        $toolMissing = ToolMissing::with(['details', 'karyawan'])->findOrFail($id);
        $pdf = PDF::loadView('Workshop.tool-usage.print-missing', compact('toolMissing'));

        return $pdf->stream();
        return view('Workshop.tool-usage.print-missing', compact('toolMissing'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $tool_usage = ToolUsage::findOrFail($id);
        $tool_usage->increaseToolsStock();
        $tool_usage->details()->delete();


        if ($tool_usage->delete()) {
            return redirect()->route('workshop.tool-usage.index');
        }
    }
}
