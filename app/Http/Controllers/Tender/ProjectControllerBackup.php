<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\Customer;
use App\Models\Tender\OpsiStatusProject;
use App\Models\Tender\OpsiTargetTender;
use App\Models\Tender\OpsiJenisTender;
use App\Models\Tender\OpsiKategoriProject;

use App\Models\Tender\OpsiUploadKategori;

class ProjectController extends Controller
{
    public function index(Request $request){
        $opsi_status_project = OpsiStatusProject::all();
        $opsi_kategori_proyek =  OpsiKategoriProject::all();
        if($request->isMethod('post')){
            /*
            customer
            projectStatus
            projectCategory
            */
            // $project = Project::where('registration_no', 123)->with(['customer'])->get();//->with('customer')->get()
            $kategori_proyek = $request->input('kategori_proyek');
            $status_proyek = $request->input('status_proyek');
            $project = Project::with(['customer','projectStatus','projectCategory'])->get();        
            if($kategori_proyek == 0 && $status_proyek == 0){
                $project = Project::with(['customer','projectStatus','projectCategory'])->get();        
            }

            if($kategori_proyek > 0 && $status_proyek > 0){                
                $project = Project::where([
                    ['project_category_id', $kategori_proyek],
                    ['project_status', $status_proyek]
                ])->with(['customer','projectStatus','projectCategory'])->get();
            }
            return view('Tender.project.daftar_project',[
                'project' => $project,
                'opsi_status_project' => $opsi_status_project,
                'opsi_kategori_proyek' => $opsi_kategori_proyek
            ]);

        } else {
            return view('Tender.project.daftar_project',[
                'project'=>[],
                'opsi_status_project' => $opsi_status_project,
                'opsi_kategori_proyek' => $opsi_kategori_proyek
            ]);
        }
    }

    public function create_project(){
        $opsi_status_project = OpsiStatusProject::all();
        $opsi_target_tender = OpsiTargetTender::all();
        $opsi_upload_kategori = OpsiUploadKategori::all();
        
        return view('Tender.project.create',[
            'opsi_status_project' => $opsi_status_project,
            'opsi_target_tender' => $opsi_target_tender,
            'opsi_upload_kategori' => $opsi_upload_kategori            
        ]);
    }

    public function create_test_project(){
        $opsi_status_project = OpsiStatusProject::all();
        $opsi_target_tender = OpsiTargetTender::all();
        $opsi_jenis_tender = OpsiJenisTender::all();
        $opsi_kategori_proyek = OpsiKategoriProject::all();
        $opsi_customer = Customer::all();
        // dd($opsi_customer);
        return view('Tender.project.create_test',[
            'opsi_status_project' => json_encode($opsi_status_project),
            'opsi_target_tender' => $opsi_target_tender,
            'opsi_jenis_tender' => $opsi_jenis_tender,
            'opsi_kategori_proyek' => $opsi_kategori_proyek,
            'opsi_customer' => json_encode($opsi_customer)
        ]);
        // return view('Tender.project.create_test')->with('opsi_status_project', json_encode($opsi_status_project));        
    }

    public function simpan_proyek_backup(Request $request){        
        
        // print_r($request->input());
        // exit();
        // print_r(!empty($request->input('existing_customer_id')));
        if(!empty($request->input('existing_customer_id'))){
            $customer_id = $request->input('existing_customer_id');
        } else {
            $customer_no = $request->input('customer_no');
            $customer_name = $request->input('customer_name');
            $insertCustomer = Customer::create([
                'customer_no' => $customer_no,
                'customer_name' => $customer_name
            ]);
            $customer_id = $insertCustomer->id;
        }
        $tender_value = str_replace( ',', '', $request->input('tender_value'));
        $simpan = Project::create([
            'tender_no' => $request->input('tender_no'), 
            'tender_desc' => $request->input('tender_desc'), 
            'tender_source' => $request->input('tender_source'), 
            'tender_date' => $request->input('tender_date'), 
            'tender_end_date' => $request->input('tender_end_date'), 
            'tender_value' => $tender_value, 
            'lokasi_project' => $request->input('project_location'),
            'status_project' => $request->input('status_project'),
            'target_tender' => $request->input('target_tender'),
            'jenis_tender' => $request->input('jenis_tender'),
            'customer_id' => $customer_id
        ]);
        // print_r($request->input());
        // print_r($tender_value);
        if($simpan){
            return response()->json('sukses', 200);
        } else {
            return response()->json('error', 404);
        }
    }
    
    public function simpan_proyek(Request $request){        
        
        // print_r($request->input());
        // return response()->json('sukses', 200);
        // exit();
        
        // print_r(!empty($request->input('existing_customer_id')));
        // if(!empty($request->input('existing_customer_id'))){
        //     $customer_id = $request->input('existing_customer_id');
        // } else {
        //     $customer_no = $request->input('customer_no');
        //     $customer_name = $request->input('customer_name');
        //     $insertCustomer = Customer::create([
        //         'customer_no' => $customer_no,
        //         'customer_name' => $customer_name
        //     ]);
        //     $customer_id = $insertCustomer->id;
        // }
        
        // $customer_id = null;
        $is_tender = 1;
        $project_value = str_replace( ',', '', $request->input('project_value'));
        $simpan = Project::create([
            'registration_no' => $request->input('registration_no'), 
            'project_desc' => $request->input('project_desc'), 
            'project_source' => $request->input('project_source'), 
            'project_start_date' => $request->input('project_start_date'), 
            'project_end_date' => $request->input('project_end_date'), 
            'project_value' => $project_value, 
            'project_location' => $request->input('project_location'),
            'project_status' => $request->input('project_status'),
            'project_target' => $request->input('project_target'),
            'project_category_id' => $request->input('project_category_id'),
            'customer_id' => $request->input('customer_id'),
            'is_tender' => $is_tender,
            'duration_in_month' => $request->input('duration_in_month')
        ]);        

        // print_r($request->input());
        // print_r($tender_value);
        if($simpan){
            return response()->json('sukses', 200);
        } else {
            return response()->json('error', 404);
        }
    }

    public function create_project_save(Request $request){
        $createProject = Project::create([
            'tender_no' => $request->input('tender_no'),
            'tender_desc' => $request->input('tender_desc'),
            'tender_source' => $request->input('tender_source'),
            'tender_date' => $request->input('tender_date'),
            'tender_end_date' => $request->input('tender_end_date'),
            'tender_value' => $request->input('tender_value'),
            'project_location' => $request->input('project_location'),
            'status' => $request->input('status'),
            'tender_target' => $request->input('tender_target'),
            'jenis' => $request->input('jenis'),            
        ]);

        if($createProject){
            return redirect(route('Tender.project.create'))->with('success','project created successfully !');
        } else {
            return redirect(route('Tender.project.create'))->with('errors','project creation Failed!');
        }
    }

    public function daftar_project(Request $request){
     $project = Project::all();
     return response()->json($project, 200);   
    }
}
