<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\Survey;
use App\Models\Tender\SurveyResult;
use App\Models\Tender\Files;
use App\Models\Tender\FileTypes;
use Carbon\Carbon;
use File;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->surveyLimitPerPage = 10;
    }

    public function index()
    {
        return view('Tender.survey.index');
    }

    public function loadDataTable(Request $request)
    {

        if($request->has(['dateOption','startDate','endDate']))
        {

            $dateOption = $request->get('dateOption') == "1" ? "created_at" : "survey.updated_at";
            $startDate = Carbon::parse($request->get('startDate'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse($request->get('endDate'))->format('Y-m-d')." 23:59:00";

            $dataSurvey = Survey::with(
                [
                    'results' => function ($query){
                        $query->select('note','created_at','survey_id');
                    },
                    'project' => function ($query){
                        $query->select('name', 'created_at as date', 'customer_id', 'status_id', 'id');
                    },
                    'assignBy.karyawan' => function($query){
                        $query->select('nm_lengkap','nik');
                    },
                    'surveyor.karyawan' => function($query){
                        $query->select('nm_lengkap','nik');
                    },
                    'project.customer' => function ($q){
                        $q->select('company_name', 'id');
                    },
                    'project.status' => function ($query){
                        $query->select('keterangan','id');
                    }
                ])
            ->when( $request->get('dateOption') == "2", function($query){
                $query->surveyHasCompleted();
            })
            ->select('id','created_at','project_id','assign_by','surveyor_id','completed_by','surveyor_group')
            ->whereBetween(
                $dateOption, [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

            return response()->json([
                'data' => $dataSurvey
            ]);
        }
    }

    // perintah atau penunjukkan survey
    public function assignment(Project $project, Request $request)
    {

        $redirectParams = [
            'route' => 'project.index',
            'args' => [],
        ];

        $assign_by = auth()->id();

        try {

            $surveyAssignment = Survey::create([
                // 'surveyor_id' => $request->input('surveyor'),
                'surveyor_group' => $request->input('hdnSurveyorGroup'),
                'date' =>  $request->input('survey_date'),
                'notes' => $request->input('survey_notes'),
                'assign_by' => $assign_by,
                'project_id' => $request->input('survey_task_project_id')
            ]);

            $project = Project::find($request->input('survey_task_project_id'));
            $project->status_id = 2;
            $project->save();

        } catch(\Illuminate\Database\QueryException $ex){
            $messages['danger'] = 'Error pada saat assign tugas survey.';
        }

        $messages['success'] = 'survey task berhasil dibuat';
        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    public function saveSurveyResult(Request $request){

        $redirectParams = [
            'route' => 'Survey.index',
            'args' => [],
        ];

        try {
            // foreach ($request->input('hdn_location_name') as $key => $value)
            // {
                $surveyResult = SurveyResult::create([
                    'survey_id' => $request->input('survey_id'),
                    // 'segment' => $request->input('hdn_location_name')[$key],
                    // 'lng' => $request->input('hdn_lng')[$key],
                    // 'lat' => $request->input('hdn_lat')[$key],
                    // 'note' => $request->input('hdn_location_note')[$key],
                    'segment' => "",
                    'lng' => "",
                    'lat' => "",
                    'note' => $request->input('survey_note'),
                    'surveyor_id' => auth()->id()
                ]);
            // }

            if($request->filled('survey_id'))
            {

                $survey = Survey::find($request->input('survey_id'));
                $survey->completed_by = auth()->id();
                $survey->save();
            }
        } catch(\Illuminate\Database\QueryException $ex)
        {
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menginput hasil survey.';
        }

        $messages['success'] = 'Hasil Survey berhasil disimpan';
        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    public function create($surveyId, $action = "create")
    {
        $fileTypes = FileTypes::all();
        $survey = Survey::find($surveyId);
        return view('components.tender.survey.form', compact('survey','action','fileTypes'));
    }

    public function edit($surveyId, $action = "edit")
    {
        $survey = Survey::with('project.preAnalystApproval')->find($surveyId);
        // dd($survey);
        $surveyResult = SurveyResult::where('survey_id', $surveyId)->get();
        $fileTypes = FileTypes::all();
        return view('components.tender.survey.form', compact('survey','surveyResult','action','fileTypes'));
    }

    public function getSurveyLocation($locationId){
        $surveyResult = SurveyResult::where('id', $locationId)->get();
        return response()->json([
            'data' => $surveyResult
        ]);
    }

    public function store(Request $request)
    {
        $redirectParams = [
            'route' => 'survey.index',
            'args' => [],
        ];

        try {

            // foreach ($request->input('hdn_location_name') as $key => $value)
            // {
                $surveyResult = SurveyResult::create([
                    'survey_id' => $request->input('survey_id'),
                    // 'segment' => $request->input('hdn_location_name')[$key],
                    // 'lng' => $request->input('hdn_lng')[$key],
                    // 'lat' => $request->input('hdn_lat')[$key],
                    // 'note' => $request->input('hdn_location_note')[$key],
                    'segment' => "",
                    'lng' => 0.0,
                    'lat' => 0.0,
                    'note' => $request->input('survey_note'),
                    'surveyor_id' => auth()->id()
                ]);
            // }

            if($request->filled('survey_id'))
            {

                $survey = Survey::find($request->input('survey_id'));
                $survey->completed_by = auth()->id();
                $survey->summary_notes = $request->input('survey_note');
                $survey->save();

                if($survey)
                {
                    if($request->hasFile('filename'))
                    {
                        foreach ($request->file('filename') as $key => $file) {
                            if($file->isValid())
                            {
                                if(!Storage::disk('public')->exists('survey'))
                                {
                                    Storage::makeDirectory('public/survey');
                                }

                                $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                                // $filePath = $file->storeAs('public/survey', $filename);
                                $uploadedFile = Files::create([
                                    'name' => $filename,
                                    'file_types_id' => $request->file_type[$key]
                                ]);

                                // $img = Image::make($file->getRealPath());
                                // $img->stream();
                                // Storage::disk('public')->put('/survey/'.$filename, $img, 'public');

                                $survey->files()->attach($uploadedFile);
                                Storage::disk('public')->put('/survey/'.$filename, File::get($file), 'public');

                            }
                        }
                    }
                }
            }

            $messages['success'] = 'Hasil Survey berhasil disimpan.';

            return redirect()
                ->route(
                    $redirectParams['route'],
                    $redirectParams['args'])
                ->with($messages);

        } catch(\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menginput hasil survey.';
        }
    }

    public function update(Survey $survey, Request $request)
    {
        $redirectParams = [
            'route' => 'survey.index',
            'args' => [],
        ];

        try {

            // update tanggal selesai survey, completed_by, summary_notes

            $survey->summary_notes = $request->survey_note;
            $survey->completed_by = auth()->id();
            $survey->save();

            // update lokasi survey

            foreach ($request->input('hdn_survey_result_id') as $key => $value){

                $currentSurveyResult = SurveyResult::find($value);
                if($currentSurveyResult){

                    $currentSurveyResult->survey_id = $request->input('survey_id');
                    $currentSurveyResult->segment = $request->input('hdn_location_name')[$key];
                    $currentSurveyResult->lat = $request->input('hdn_lat')[$key];
                    $currentSurveyResult->lng = $request->input('hdn_lng')[$key];
                    $currentSurveyResult->note = $request->input('hdn_location_note')[$key];
                    $currentSurveyResult->surveyor_id = auth()->id();
                    $currentSurveyResult->save();

                } else {
                    $newSurveyResult = SurveyResult::create([
                        'survey_id' => $request->input('survey_id'),
                        'segment' => $request->input('hdn_location_name')[$key],
                        'lat' => $request->input('hdn_lat')[$key],
                        'lng' => $request->input('hdn_lng')[$key],
                        'note' => $request->input('hdn_location_note')[$key],
                        'surveyor_id' => auth()->id()
                    ]);
                }
            }
            // jika ada upload file baru
            if($request->hasFile('filename'))
            {
                foreach ($request->file('filename') as $key => $file) {
                    if($file->isValid())
                    {
                        if(!Storage::disk('public')->exists('survey'))
                        {
                            Storage::makeDirectory('public/survey');
                        }

                        $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());

                        $uploadedFile = Files::create([
                            'name' => $filename,
                            'file_types_id' => $request->file_type[$key]
                        ]);

                        $survey->files()->attach($uploadedFile);
                        Storage::disk('public')->put('/survey/'.$filename, File::get($file), 'public');
                    }
                }
            }

            // cek jika user ingin menghapus dokumen
            if($request->has(['fileIdsToBeDelete','fileNamesToBeDelete'])){

              foreach ($request->input('fileIdsToBeDelete') as $key => $arrayOfValues) {
                $fileIds = explode(",", $arrayOfValues);
                $fileNames = explode(",", $request->input('fileNamesToBeDelete')[$key]);
              }

              Files::destroy($fileIds);
              $survey->files()->detach($fileIds);

              foreach($fileNames as $index => $filename){
                if(Storage::disk('public')->exists('survey')){
                  Storage::disk('public')->delete('survey/'. $filename);
                }
              }
            }

            $messages['success'] = 'Hasil Survey berhasil diupdate.';


        } catch(\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat update hasil survey.';
        }

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    public function updateSurveyResult(Request $request)
    {
        dd($request->input());
    }
}
