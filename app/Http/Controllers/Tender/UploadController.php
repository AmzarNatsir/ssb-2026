<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\OpsiUploadKategori;
use App\Models\Tender\ProjectFiles;
use Image;

class UploadController extends Controller
{

    public function index(Request $request){
        $upload_kategori = OpsiUploadKategori::all();
        return view('Tender.project.upload', [
            'opsi_upload_kategori' => $upload_kategori
        ]);
        // return response()->json('upload controller index');
    }

    public function get_upload_kategori(){
        return response()->json(OpsiUploadKategori::all(), 200);
    }

    public function get_max_upload_per_kategori($id){
        $max_upload = OpsiUploadKategori::where('id', $id)->get();        
        return response()->json($max_upload, 200);
    }

    public function upload_form($project_id){
        $upload_kategori = OpsiUploadKategori::all();
        return view('Tender.project.upload_form', [
            'opsi_upload_kategori' => $upload_kategori,
            'project_id' => $project_id
        ]);
    }

    public function upload_file(Request $request){
        // return response()->json([$request->all()]);
        // exit();
        // return $request->file;

        if ($request->file){
            $image =  $request->file;        
            // $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $name = $request->input('nama_file').'.'. explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            // $name = $request->input('nama_file');
            Image::make($request->file)->save(public_path('assets\\images\\upload\\').$name);
        }

        if(ProjectFiles::create([
            'project_file_id' => $request->input('project_file_id'),
            'tender_id' => $request->input('tender_id'),
            'file' =>  $name
        ])){
            return response()->json('upload berhasil!');
        }
    }

    public function project_files($project_id){
        $files = ProjectFiles::where('tender_id', $project_id)->get();
        return response()->json($files, 200);
    }
}
