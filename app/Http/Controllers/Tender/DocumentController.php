<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tender\Project;
use App\Models\Tender\Files;
use App\Models\Tender\FileTypes;
use App\Models\Tender\FileTypesCategory;
use Storage;
use File;

class DocumentController extends Controller
{
    public function index()
    {
        $fileTypes = FileTypes::where('file_types_category_id', 1)->orderBy('name', 'asc')->get();
        $fileTypesCategory = FileTypesCategory::where('id', 1)->get();
        return view('Tender.dokumen.index', compact('fileTypes','fileTypesCategory'));
    }

    public function loadDataTable()
    {
        $fixedDocuments = Files::with('filetype')->whereHas('filetype', function($query){
            $query->where('file_types_category_id', 1)->select('name');
        })->get();

        return response()->json([
    		'data' => $fixedDocuments
    	]);
    }

    public function create($action = "create")
    {
        $fileTypes = FileTypes::where('file_types_category_id', 1)->get();
        return view('components.tender.dokumen.form', compact('action','fileTypes'));
    }

    public function edit($documentId, $action = "edit")
    {
        // return view
    }

    public function update(Files $files, Request $request)
    {
        // return view
    }

    public function store(Request $request)
    {        
        $redirectParams = [
    		'route' => 'document.index',
    		'args' => [],
    	];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'file_types' => 'required',
            'upload' => 'required|max:10240'
        ]);
        
        try {
            
            if(!$validator->fails())
            {                
                $filename = str_replace(' ', '_', strtolower($request->input('name'))).'.'.$request->file('upload')->getClientOriginalExtension();
                Files::create([
                    'name' => $filename,
                    'desc' => $request->input('name'),
                    'file_types_id' => $request->input('file_types')
                ]);
    
                Storage::disk('public')->put('/project/'.$filename, File::get($request->file('upload')));
                $messages['success'] = 'sukses: menambah fixed dokumen';            
            }

        } catch(\Illuminate\Database\QueryException $ex)
        {
            $messages['danger'] = 'error: menambah fixed dokumen';
        }

        return redirect()->route(
    		$redirectParams['route'],
    		$redirectParams['args']
    	)->with($messages);
                
    }

    public function getfixedDocumentByType($filetypeid = null)
    {                
        $document = Files::when($filetypeid, function($query, $filetypeid){
            return $query->where('file_types_id', $filetypeid);
        })
        ->join('file_types as b', 'files.file_types_id', '=', 'b.id')
        ->selectRaw('files.id,files.desc,files.file_types_id')
        ->where('b.file_types_category_id', 1)        
        ->get();
        
        return response()->json([
            'data' => $document 
        ]);

        /*
        $fixedFile = Files::join('file_types as b', 'files.file_types_id', '=', 'b.id')
        ->selectRaw('files.id,files.desc,files.file_types_id')
        ->where('b.file_types_category_id', 1)
        ->get();
        */
    }
}
