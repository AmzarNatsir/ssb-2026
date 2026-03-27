<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Supplier;
use App\Models\Workshop\ToolsReceiving;
use App\Models\Workshop\ToolsReceivingItems;
use Illuminate\Http\Request;

class ToolReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $toolsReceivings = ToolsReceiving::with(['supplier'])->latest();
        $toolsReceivings = $toolsReceivings->paginate(ToolsReceiving::PAGE_LIMIT);
        $page = $request->has('page') ? $request->page : 0;

        return view('Workshop.tool-receiving.index', compact('toolsReceivings','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('Workshop.tool-receiving.add-edit', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $toolsReceiving = new ToolsReceiving();
        $toolsReceiving->fill($request->all());
        $toolsReceiving->description = $request->remarks;

        if ($toolsReceiving->save()) {
            foreach ($request->part_id as $key => $value) {
                $item = new ToolsReceivingItems();
                $item->tools_id = $value;
                $item->qty = $request->qty[$key];
                $item->description = $request->description[$key];

                $toolsReceiving->details()->save($item);
            }

            $toolsReceiving->increaseToolsStock();

            return redirect()->route('workshop.tool-receiving.index');
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
        $toolsReceiving = ToolsReceiving::findOrFail($id);
        $suppliers = Supplier::all();

        return view('Workshop.tool-receiving.add-edit', compact('toolsReceiving','suppliers'));
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
        $toolsReceiving = ToolsReceiving::findOrFail($id);
        $toolsReceiving->fill($request->all());
        $toolsReceiving->description = $request->remarks;
        $toolsReceiving->decreaseToolsStock();

        if ($toolsReceiving->save()) {
            $toolsReceiving->details()->delete();
            foreach ($request->part_id as $key => $value) {
                $item = new ToolsReceivingItems();
                $item->tools_id = $value;
                $item->qty = $request->qty[$key];
                $item->description = $request->description[$key];

                $toolsReceiving->details()->save($item);
            }

            $toolsReceiving->increaseToolsStock();

            return redirect()->route('workshop.tool-receiving.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toolsReceiving = ToolsReceiving::findOrFail($id);
        $toolsReceiving->decreaseToolsStock();
        $toolsReceiving->details()->delete();

        if ($toolsReceiving->delete()) {
            return redirect()->route('workshop.tool-receiving.index');
        }
    }
}
