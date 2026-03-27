<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\PreAnalystApproval;
use App\Models\Tender\Files;
use App\Models\Tender\FileTypes;
// use App\User;
use Carbon\Carbon;
use Storage;
use File;
use Config;

class PreAnalystController extends Controller
{
    public function index()
    {
    	return view('Tender.project.pre_analyst');
    }

    public function loadDataTable(Request $request)
    {

    	if($request->has(['opsiStatus','startDate','endDate']))
        {
            $opsiStatus = $request->input('opsiStatus');
            $startDate = Carbon::parse($request->get('startDate'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse($request->get('endDate'))->format('Y-m-d')." 23:59:59";

            if($opsiStatus == "0" || $opsiStatus == "")
            {

                $preanalyst = Project::select('projects.id as id',
                                'projects.name as name',
                                'projects.source as source',
                                'projects.value as value',
                                'projects.created_at as created_at',
                                'projects.location as location')->whereBetween('projects.created_at', [$startDate, $endDate])
                            ->withDoesntHaveApproval()
                            ->orderBy('projects.created_at')->get();

            } else {

                $preanalyst = Project::select('projects.id as id',
                                'projects.name as name',
                                'projects.source as source',
                                'projects.value as value',
                                'projects.created_at as created_at',
                                'projects.location as location')
                            ->whereBetween('projects.created_at', [$startDate, $endDate])
                            ->withHasApproval()
                            ->orderBy('projects.created_at')->get();
            }

            return response()->json([
                'data' => $preanalyst
            ]);
        }
    }

    public function create($projectId, $action = "create"){
        $fileTypes = FileTypes::all();
        $opsiRekomendasi = Config::get("constants.preanalyst.opsi_rekomendasi");
        return view('components.tender.preanalyst.form', compact('action','fileTypes','opsiRekomendasi','projectId'));
    }

    public function edit($projectId, $action = "edit"){
        $opsiRekomendasi = Config::get("constants.preanalyst.opsi_rekomendasi");
        $fileTypes = FileTypes::all();
        $preAnalystApproval = PreAnalystApproval::where('project_id', $projectId)->first();
        return view('components.tender.preanalyst.form', compact('action','fileTypes','preAnalystApproval','opsiRekomendasi','projectId'));
    }

    public function store(Request $request){

        $redirectParams = [
            'route' => 'preanalyst.index',
            'args' => [],
        ];

        // dd($request->input('rekomendasi'));

        try {
            $preanalyst = PreAnalystApproval::create([
                'is_approve' => $request->input('rekomendasi'),
                'user_id' => auth()->id(),
                'project_id' => $request->input('project_id'),
                'note' => $request->input('note'),
            ]);

            $preanalyst->save();

            if($preanalyst)
            {
                if($request->hasfile('filename')){
                    foreach ($request->file('filename') as $key => $file) {
                        if ($file->isValid()) {
                            if(!Storage::disk('public')->exists('preanalyst'))
                            {
                              Storage::makeDirectory('public/preanalyst');
                            }

                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            // $filePath = $file->storeAs('public/preanalyst', $filename);
                            $uploadedFile = Files::create([
                                'name' => $filename,
                                'file_types_id' => $request->file_type[$key]
                            ]);

                            $preanalyst->files()->attach($uploadedFile);
                            Storage::disk('public')->put('/preanalyst/'.$filename, File::get($file), 'public');
                        }
                    }
                }

            }
        } catch(\Illuminate\Database\QueryException $ex){
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menginput preanalyst.';
        }

        $messages['success'] = 'PreAnalyst berhasil disimpan';

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    // public function update(PreAnalystApproval $preAnalystApprovalId, Request $request){
    //     dd($request->input());
    // }
}
