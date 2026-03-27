<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Workshop\MasterData\ToolCategory;
use App\Models\Workshop\MasterData\Tools;
use App\Models\Workshop\ToolHistory;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tools = Tools::with('category')->paginate(Tools::PAGE_LIMIT);
        $toolCategories = ToolCategory::all();
        $page = $request->has('page') ? $request->page : 0;

        return view('Workshop.master-data.tools.index', [
            'tools' => $tools,
            'tool_categories' => $toolCategories->toJson(JSON_PRETTY_PRINT),
            'page' => $page,
            'limit' => $tools->firstItem()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tool = new Tools();
        $tool->fill($request->all());
        $tool->picture = $request->picture ? do_upload('tools', $request->file('picture')):null;

        if ($tool->save()) {
            ToolHistory::capture($tool, $tool,0);
            return redirect()->route('workshop.master-data.tools.index');
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
        //
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
        $tool = Tools::findOrFail($id);
        $currentQty = $tool->qty;
        $tool->fill($request->all());

        if ($request->exists('picture')) {
            $tool->picture = do_upload('tools', $request->file('picture'));
        }

        if ($tool->save()) {
            ToolHistory::capture($tool, $tool, $currentQty);
            return redirect()->route('workshop.master-data.tools.index');
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
        //
    }

    public function history(Request $request , $tools)
    {
        $tools = Tools::findOrFail($tools);
        $dateStart = $request->filled('start') ? $request->start : null;
        $dateEnd = $request->filled('end') ? $request->end : null;
        $toolHistory = $tools->getHistory($dateStart, $dateEnd)->get();

        return view('Workshop.master-data.tools.history', compact('tools', 'dateStart', 'dateEnd', 'toolHistory'));
    }
}
