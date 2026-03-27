<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\OpsiStatusProject;
use App\Models\Tender\OpsiTipeProject;
// use App\Models\Tender\OpsiTargetTender;
// use App\Models\Tender\OpsiJenisTender;
use App\Models\Tender\OpsiKategoriProject;
use App\Models\Tender\Customer;
use App\Models\Tender\Project;
use App\Models\Tender\ProjectKomite;
use App\Models\Tender\Files;
use App\Models\Tender\ProjectApproval;
use App\Models\Tender\FileTypes;
use App\Models\Tender\Survey;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;
use App\Models\Tender\Contract;
use App\Models\Tender\WorkAssignment;
use App\Models\Workshop\Location;
use App\Http\Requests\Tender\StoreProjectPost;
use App\User;
use Config;
use Spatie\Permission\Models\Role;

// use File;
// use Spatie\Permission\Models\Permission;
use PDF;
use Storage;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\ProjectHelper;
use File;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->projectLimitPerPage = 10;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private function create_project_number()
    {

      $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
      $monthInRoman = '';
      $number = date('m');
      while ($number > 0) {
          foreach ($map as $roman => $int) {
              if($number >= $int) {
                  $number -= $int;
                  $monthInRoman .= $roman;
                  break;
              }
          }
      }

      $project = Project::orderByDesc('created_at')->limit(1)->select('number')->get()->first();
      $currentDigit = (int)substr($project->number, 0, 4) + 1;
      $newDigit = str_pad($currentDigit, 4, "0", STR_PAD_LEFT);
      return $newDigit."/PRO-SSB/".$monthInRoman."/".date('Y');
    }

    public function index()
    {
        $opsiStatusProject = OpsiStatusProject::all();
        $opsiKategoriProject = OpsiKategoriProject::all();
        $opsiTipeProject = OpsiTipeProject::all();
        $customers = Customer::all();
        $opsiTargetTender = Config::get("constants.project.target_tender");
        $opsiJenisProject = Config::get("constants.project.jenis");
        $fileTypes = FileTypes::all();

        $projects = Project::paginate($this->projectLimitPerPage);
        // $surveyors = User::role('project_survey')->with('karyawan')->get();
        $surveyors = User::with('karyawan')->get();
        $surveyorGroup = User::role('project_survey')->with('karyawan')->get();

        return view('Tender.project.index', compact(
            'opsiStatusProject',
            'opsiKategoriProject',
            'opsiTipeProject',
            'opsiTargetTender',
            'opsiJenisProject',
            'fileTypes',
            'customers',
            'projects',
            'surveyors',
            'surveyorGroup'
        ));
    }

    public function loadDataTable(Request $request)
    {

        if($request->has(['opsiKategori','opsiTipe','opsiStatus']))
        {
            $opsiKategori = $request->input('opsiKategori');
            $opsiTipe = $request->input('opsiTipe');
            $opsiStatus = $request->input('opsiStatus');

            $projects = Project::with([
                'customer' => function ($query){
                    $query->select('company_name','id');
                },
                'category' => function ($query){
                    $query->select('keterangan','id');
                },
                'status' => function ($query){
                    $query->select('keterangan','id');
                },
                'type' => function ($query){
                    $query->select('keterangan','id');
                },
                'survey' => function ($query){
                    $query->select('project_id', 'id');
                }
            ])
            ->when($opsiKategori, function($query, $opsiKategori){
                return $query->where('category_id', $opsiKategori);
            })
            ->when($opsiTipe, function($query, $opsiTipe){
                return $query->where('tipe_id', $opsiTipe);
            })
            ->when($opsiStatus, function($query, $opsiStatus){
                return $query->where('status_id', $opsiStatus);
            })
            ->isSurveyAssigned()
            ->select('id','number','name','desc','source','start_date','end_date','value','created_at','customer_id','status_id','tipe_id','category_id','location')
            ->orderBy('created_at', 'desc')
            ->get();

            return response()->json([
                'data' => $projects
            ]);
        }

    }

    public function view($projectId)
    {
        $project = Project::where('id', $projectId)
            ->with([
                'status',
                'preAnalystApproval.files',
                'survey',
                'survey.surveyor',
                'survey.results',
                'approval.user',
                'boq.detail.equipment',
                'bond',
                'auction',
                'files.filetype',
                'contract',
                'workAssignment'
            ])->first();

        // $surveyors = User::role('project_survey')->with('karyawan')->get();
        $surveyors = User::with('karyawan')->get();
        $surveyorGroup = User::role('project_survey')->with('karyawan')->get();

        return view('Tender.project.view',
            compact('projectId', 'project','surveyors','surveyorGroup')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($action = "create")
    {
        $opsiKategoriProject = OpsiKategoriProject::all();
        $opsiStatusProject = OpsiStatusProject::all();
        $opsiTipeProject = OpsiTipeProject::all();
        $customers = Customer::all();
        $opsiTargetTender = Config::get("constants.project.target_tender");
        $opsiJenisProject = Config::get("constants.project.jenis");
        $fileTypes = FileTypes::where('file_types_category_id', 2)->orderBy('name', 'asc')->get();
        $fixedfileTypes = FileTypes::where('file_types_category_id', 1)->orderBy('name', 'asc')->get();

        $fixedFile = Files::join('file_types as b', 'files.file_types_id', '=', 'b.id')
        ->selectRaw('files.id,files.desc,files.file_types_id')
        ->where('b.file_types_category_id', 1)
        ->get();

        // $projectNumber = ProjectHelper::create_project_number();
        $projectNumber = $this->create_project_number();

        return view('components.tender.project.form', compact(
            'opsiKategoriProject',
            'opsiStatusProject',
            'opsiTipeProject',
            'customers',
            'opsiTargetTender',
            'opsiJenisProject',
            'action',
            'fileTypes',
            'fixedfileTypes',
            'fixedFile',
            'projectNumber'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $redirectParams = [
            'route' => 'project.index',
            'args' => [],
        ];

        // dd($request->input());
        // dd(!is_null($request->input('fixed_file')[0]));
        if($request->filled('existing_customer_opt'))
        {
            try
            {

                $customer = Customer::find($request->existing_customer_opt);
                $project = Project::create([
                    'name' => $request->project_name,
                    'number' => $request->project_number,
                    'desc' => $request->project_desc,
                    'source' => $request->project_source,
                    'start_date' => $request->project_start_date,
                    'end_date' => $request->project_end_date,
                    'status_id' => head(Config::get("constants.project.status"))['kode'],
                    'category_id' => $request->project_category,
                    'value' => $request->tender_value !== "" ? str_replace(',', '', $request->tender_value) : $request->tender_value,
                    'target_tender_id' => $request->project_target,
                    'tipe_id' => $request->project_type,
                    'location' => $request->project_location,
                    'customer_id' => $customer->id,
                    'jenis_project_id' => $request->project_jenis,
                    'created_by' => auth()->id()
                ]);

                if($project){

                    if( !is_null($request->input('fixed_file')[0]) )
                    {
                        foreach ($request->input('fixed_file') as $key => $file) {
                            $project->files()->attach($file);
                        }
                    }

                    if ($request->hasfile('filename')) {

                        foreach ($request->file('filename') as $key => $file) {
                            if ($file->isValid()) {

                                if(!Storage::disk('public')->exists('project'))
                                {
                                  Storage::makeDirectory('public/project');
                                }


                                $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                                $uploadedFile = Files::create([
                                    'name' => $filename,
                                    'file_types_id' => $request->file_type[$key]
                                ]);

                                // $img = Image::make($file->getRealPath());
                                // $img->stream();

                                $project->files()->attach($uploadedFile);
                                Storage::disk('public')->put('/project/'.$filename, File::get($file));
                            }

                        }
                    }

                }

            }
            catch(\Illuminate\Database\QueryException $ex)
            {
                dd($ex->getMessage());
                $messages['danger'] = 'Error pada saat menginput project.';
            }


        } else {

            try
            {
                $project = Project::create([
                    'name' => $request->project_name,
                    'number' => $request->project_number,
                    'desc' => $request->project_desc,
                    'source' => $request->project_source,
                    'start_date' => $request->project_start_date,
                    'end_date' => $request->project_end_date,
                    'status_id' => head(Config::get("constants.project.status"))['kode'],
                    'tipe_id' => $request->project_type,
                    'category_id' => $request->project_category,
                    'value' => $request->tender_value !== "" ? str_replace(',', '', $request->tender_value) : $request->tender_value,
                    'target_tender_id' => $request->project_target,
                    'location' => $request->project_location,
                    'jenis_project_id' => $request->project_jenis,
                    'created_by' => auth()->id()
                ]);

                $customer = new Customer([
                    'company_name' => $request->company_name,
                    'company_address' => $request->company_address,
                    'contact_person_name' => $request->contact_person_name,
                    'contact_person_number' => $request->contact_person_number,
                ]);

                $customer->save();

                $project->customer()->associate($customer);
                $project->save();

                if($project)
                {
                    if( !is_null($request->input('fixed_file')[0]) )
                    {
                        foreach ($request->input('fixed_file') as $key => $file) {
                            $project->files()->attach($file);
                        }
                    }

                    if ($request->hasfile('filename')) {

                        foreach ($request->file('filename') as $key => $file) {
                            if ($file->isValid()) {

                                if(!Storage::disk('public')->exists('project'))
                                {
                                  Storage::makeDirectory('public/project');
                                }

                                $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                                $uploadedFile = Files::create([
                                    'name' => $filename,
                                    'file_types_id' => $request->file_type[$key]
                                ]);

                                $img = Image::make($file->getRealPath());
                                $img->stream();

                                $project->files()->attach($uploadedFile);
                                Storage::disk('public')->put('/project/'.$filename, $img, 'public');
                            }

                        }


                    }

                }

            }
            catch(\Illuminate\Database\QueryException $ex)
            {
                dd($ex->getMessage());
                $messages['danger'] = 'Error pada saat menginput project.';
            }

        }

        $messages['success'] = 'Project baru berhasil dibuat';

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId, $action = "edit")
    {
        $opsiStatusProject = OpsiStatusProject::all();
        $opsiKategoriProject = OpsiKategoriProject::all();
        $opsiTipeProject = OpsiTipeProject::all();
        $customers = Customer::all();
        $opsiTargetTender = Config::get("constants.project.target_tender");
        $opsiJenisProject = Config::get("constants.project.jenis");
        $project = Project::find($projectId);
        $fileTypes = FileTypes::where('file_types_category_id', 2)->orderBy('name', 'asc')->get();
        $fixedfileTypes = FileTypes::where('file_types_category_id', 1)->orderBy('name', 'asc')->get();
        $fixedFile = Files::join('file_types as b', 'files.file_types_id', '=', 'b.id')
        ->selectRaw('files.id,files.desc,files.file_types_id')
        ->where('b.file_types_category_id', 1)
        ->get();

        return view('components.tender.project.form', compact(
            'project',
            'opsiStatusProject',
            'opsiKategoriProject',
            'opsiTipeProject',
            'opsiTargetTender',
            'opsiJenisProject',
            'customers',
            'action',
            'fileTypes',
            'fixedfileTypes',
            'fixedFile'
        ));
    }

    public function showAktivasiForm($projectId)
    {
        $project = Project::find($projectId);
        $workAssignment = WorkAssignment::where('project_id', $projectId)->first();
        return view('components.tender.project.form_aktivasi_project', compact('project','workAssignment'));
    }

    public function activation(Request $request)
    {
        $redirectParams = [
          'route' => 'project.index',
          'args' => [],
        ];

        try {

            Contract::create([
              'project_id' => $request->input('project_id'),
              'user_id' => auth()->id(),
              'contract_no' => $request->input('contract_no'),
              'contract_date' => $request->input('contract_date'),
              'auction_pass_letter_no' => $request->input('auction_pass_letter_no'),
              'auction_pass_letter_date' => $request->input('auction_pass_letter_date'),
              'kickoff_meeting_date' => $request->input('kickoff_date'),
              'kickoff_meeting_note' => $request->input('kickoff_note'),
            ]);

            $project = Project::find($request->input('project_id'));
            $project->number = $request->input('project_number');
            $project->start_date = $request->input('work_start_date');
            $project->end_date = $request->input('work_end_date');
            $project->status_id = 4; // aktif
            $project->save();

            // save to workshop location
            Location::create(['location_name'=> $project->location ]);

            $messages['success'] = 'Aktivasi Project berhasil';

        } catch(\Illuminate\Database\QueryException $ex)
        {
            // dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat Aktivasi project.';

        }

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }


    public function closeProject(Request $request)
    {

      $redirectParams = [
          'route' => 'project.index',
          'args' => [],
      ];

      try {

        $project = Project::find($request->input('project_id'));
        $project->status_id = 5;
        $project->save();

        $messages['success'] = 'Closing Project berhasil';

      } catch(\Illuminate\Database\QueryException $ex)
      {
        dd($ex->getMessage());
        $messages['danger'] = 'Error pada saat closing project.';
      }

      return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, Request $request)
    {
        $redirectParams = [
            'route' => 'project.index',
            'args' => [],
        ];

        $project->name = $request->project_name;
        $project->number = $request->project_number;
        $project->desc = $request->project_desc;
        $project->source = $request->project_source;
        $project->start_date = $request->project_start_date;
        $project->end_date = $request->project_end_date;
        $project->value = $request->tender_value !== "" ? str_replace(',', '', $request->tender_value) : $request->tender_value;
        $project->tipe_id = $request->project_type;
        $project->target_tender_id = $request->project_target;
        $project->category_id = $request->project_category;
        $project->jenis_project_id = $request->project_jenis;
        $project->customer_id = $request->existing_customer_opt;
        $project->updated_by = auth()->id();

        if($project)
        {
            if( !is_null($request->input('fixed_file')[0]) )
            {
                foreach ($request->input('fixed_file') as $key => $file) {
                    $project->files()->attach($file);
                }
            }

            if ($request->hasfile('filename')) {
                foreach ($request->file('filename') as $key => $file) {
                    if ($file->isValid()) {

                        if(!Storage::disk('public')->exists('project'))
                        {
                          Storage::makeDirectory('public/project');
                        }

                        $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                        // $filePath = $file->storeAs('public/project', $filename);
                        $uploadedFile = Files::create([
                            'name' => $filename,
                            'file_types_id' => $request->file_type[$key]
                        ]);

                        // $img = Image::make($file->getRealPath());
                        // $img->stream();

                        // $theFile = File::get();

                        $project->files()->attach($uploadedFile);
                        Storage::disk('public')->put('/project/'.$filename, File::get($file));
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
              $project->files()->detach($fileIds);

              foreach($fileNames as $index => $filename){
                if(Storage::disk('public')->exists('project')){
                  Storage::disk('public')->delete('project/'. $filename);
                }
              }
            }

        }

        $project->save();

        $messages['success'] = 'Project update successfully';

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }

    public function approval(){

        $opsiDepartemen = DepartemenModel::orderBy('nm_dept', 'asc')->get();
        $opsiJabatan = JabatanModel::orderBy('nm_jabatan', 'asc')->get();
        $opsiKaryawan = KaryawanModel::where('id_status_karyawan', 3)->orderBy('nm_lengkap', 'asc')->get();


        // load data approval & komitenya;
        /*
            SELECT
            a.approval_order AS urutan,
            c.nm_lengkap AS nama_komite,
            d.nm_jabatan AS jabatan,
            b.hasil,
            b.note
            FROM project_komite a
            LEFT JOIN project_approval b ON a.karyawan_id=b.user_id AND b.project_id=1
            LEFT JOIN hrd_karyawan c ON a.karyawan_id=c.id
            LEFT JOIN mst_hrd_jabatan d ON c.id_jabatan=d.id
            WHERE a.active=1
            ORDER BY a.approval_order ASC;
        */

        /*
            ->leftJoin('table3 AS c', function($join){
                $join->on('a.field2', '=', 'c.field2')
                ->where('a.field2', '=', true)
                ->where('a.field3', '=', 'c.field3');
            })
        */

            // mau dipindahkan ke method sendiri dan difetch sbg ajax
        $projectId = 1;
        $komiteDanApproval = \DB::table('project_komite as a')
                            ->select(
                                'a.id AS komite_id',
                                'a.approval_order AS urutan',
                                'c.nm_lengkap AS nama_komite',
                                'd.nm_jabatan AS jabatan',
                                'b.hasil',
                                'b.note',
                                'b.user_id',
                                'a.karyawan_id'
                            )
                            ->leftJoin('project_approval as b',
                                function($join) use($projectId)
                                {
                                    $join->on('a.karyawan_id', '=', 'b.user_id')
                                    ->where('b.project_id', '=', $projectId);
                                }
                            )
                            ->leftJoin('hrd_karyawan as c', 'a.karyawan_id', '=', 'c.id')
                            ->leftJoin('mst_hrd_jabatan as d', 'c.id_jabatan', '=', 'd.id')
                            ->where('a.active', 1)
                            ->orderBy('a.approval_order', 'asc')
                            ->get();

        $projects = Project::where('status_id', 1)->get();

        return view('Tender.project.approval',
            compact(
                'projects',
                'opsiKaryawan',
                'opsiJabatan',
                'opsiDepartemen',
                'komiteDanApproval'
            )
        );
    }


    public function loadApprovalDataTable(Request $request)
    {

        // $comiteeNumber = ProjectKomite::where('active', 1)->count();
        // $currentApproval = ProjectApproval::groupBy('project_id')
        //                     ->having(\DB::raw('count(*)'), '<=', $comiteeNumber)
        //                     ->select('project_id')
        //                     ->get()
        //                     ->toArray();

        if($request->has(['startDate','endDate'])){

            $startDate = Carbon::parse($request->get('startDate'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse($request->get('endDate'))->format('Y-m-d')." 23:59:00";

            // $startDate = $request->get('startDate');
            // $endDate = $request->get('endDate');

            $approval = Project::with(['approval' => function ($query){
                $query->where('project_approval.project_id', 'projects.id');
            }])
            ->leftJoin('survey', function($join){
                $join->on('projects.id', '=', 'survey.project_id');
            })
            ->leftJoin('users', function($join){
                $join->on('survey.completed_by', '=', 'users.id');
            })
            ->leftJoin('hrd_karyawan', function($join){
                $join->on('users.nik', '=', 'hrd_karyawan.nik');
            })
            ->selectRaw("
                projects.id,
                projects.name as project_name,
                DATE_FORMAT(projects.created_at, '%d/%m/%Y') as project_date,
                hrd_karyawan.nm_lengkap as survey_completed_by,
                DATE_FORMAT(projects.updated_at, '%d/%m/%Y') as survey_completed_on
            ")
            ->where('projects.status_id', 2)
            ->whereBetween('projects.created_at', [$startDate, $endDate])
            ->withProjectManagerApproval("projects.id", 11) // ubah sesuai id jabatan
            ->withOpsManagerApproval("projects.id", 7) // ubah sesuai id jabatan
            ->withDirectorApproval("projects.id", 3) // ubah sesuai id jabatan
            ->whereNotNull('survey.completed_by')
            ->get();

            return response()->json([
                'data' => $approval
            ]);
        }

    }

    public function loadFormApproval($projectId){
        $project = Project::where('id', $projectId)->get()->toArray();
        $komiteDanApproval = \DB::table('project_komite as a')
                            ->select(
                                'a.id AS komite_id',
                                'a.approval_order AS urutan',
                                'c.nm_lengkap AS nama_komite',
                                'd.nm_jabatan AS jabatan',
                                'b.hasil',
                                'b.note',
                                'b.user_id',
                                'a.karyawan_id'
                            )
                            ->leftJoin('project_approval as b',
                                function($join) use($projectId)
                                {
                                    $join->on('a.karyawan_id', '=', 'b.user_id')
                                    ->where('b.project_id', '=', $projectId);
                                }
                            )
                            ->leftJoin('hrd_karyawan as c', 'a.karyawan_id', '=', 'c.id')
                            ->leftJoin('mst_hrd_jabatan as d', 'c.id_jabatan', '=', 'd.id')
                            ->where('a.active', 1)
                            ->orderBy('a.approval_order', 'asc')
                            ->get();
        return view('components.tender.approval.form',
            compact(
                'komiteDanApproval',
                'project',
                'projectId'
            )
        );
    }

    public function saveApproval(Request $request){

        $redirectParams = [
            'route' => 'Approval.index',
            'args' => [],
        ];

        try {
            // TODO projectApproval model
            ProjectApproval::create([
                'project_id' => $request->input('project_id'),
                // 'user_id' => auth()->id(),
                'user_id' => auth()->user()->karyawan->id,
                'hasil' => $request->input('hasil'),
                'note' => $request->input('note')
            ]);

            $countApproval = ProjectApproval::where('project_id', $request->input('project_id'))
                                ->where('hasil', 1)
                                ->count();
            $countKomite = ProjectKomite::all()->count();

            if($countApproval == $countKomite)
            {
                $project = Project::find($request->input('project_id'));
                $project->status_id = 3;
                $project->save();
            }

            $messages['success'] = 'Persetujuan project berhasil disimpan';

        } catch(\Illuminate\Database\QueryException $ex){
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menyimpan persetujuan project.';
        }

        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);

    }

    public function cetakApproval(Request $request, $projectId)
    {
        $project = Project::with('customer')->find($projectId);
        $approval = \DB::table('project_komite as a')
                            ->select(
                                'a.id AS komite_id',
                                'a.approval_order AS urutan',
                                'c.nm_lengkap AS nama_komite',
                                'd.nm_jabatan AS jabatan',
                                'b.hasil',
                                'b.note',
                                'b.user_id',
                                'a.karyawan_id',
                                'b.created_at as tgl_approval'
                            )
                            ->leftJoin('project_approval as b',
                                function($join) use($projectId)
                                {
                                    $join->on('a.karyawan_id', '=', 'b.user_id')
                                    ->where('b.project_id', '=', $projectId);
                                }
                            )
                            ->leftJoin('hrd_karyawan as c', 'a.karyawan_id', '=', 'c.id')
                            ->leftJoin('mst_hrd_jabatan as d', 'c.id_jabatan', '=', 'd.id')
                            ->where('a.active', 1)
                            ->orderBy('a.approval_order', 'asc')
                            ->get();
        // cetak_approve.blade.php
        $pdf = PDF::loadview('Tender.project.partials.cetak_approve', compact('approval','project'));
        return $pdf->stream();
        // return $pdf->download('project_approval.pdf');

    }

    public function filterJabatan(Request $request, $iddept){
            $jabatan = JabatanModel::where('id_dept', $iddept)
                        ->orderBy('nm_jabatan', 'asc')
                        ->get(['id','nm_jabatan']);

            return response()->json([
                'status' => 'ok',
                'data' => $jabatan,
            ]);
    }

    public function filterKaryawan(Request $request, $idjabt){
        if(!empty($idjabt))
        {
            $karyawan = KaryawanModel::where('id_jabatan', $idjabt)
                        ->orderBy('nm_lengkap', 'asc')
                        ->get(['id','nm_lengkap']);

            return response()->json([
                'status' => 'ok',
                'data' => $karyawan,
            ]);
        }
    }

    public function saveKomite(Request $request){

        $redirectParams = [
            'route' => 'Komite.index',
            'args' => [],
        ];

        try {

            $isKomiteExist = ProjectKomite::where('karyawan_id', $request->input("daftar_kary"))->get();
            if($isKomiteExist->count() > 0)
            {

                $projetKomite = ProjectKomite::where('karyawan_id', $request->input("daftar_kary"))
                    ->update([
                        'approval_order' => $request->has('update_order') ? $request->input('update_order') : $isKomiteExist->first()->approval_order,
                        'updated_by' => auth()->id(),
                        'active' => $request->has('status') ? $request->input('status') : $isKomiteExist->first()->active,
                    ]);

                $messages['danger'] = 'Anggota Komite sudah ada sebelumnya';

            } else {

                $lastMember = ProjectKomite::orderBy('approval_order','desc')->first('approval_order');
                if ($lastMember === null) {
                    $lastMember = (object) ['approval_order' => 1];
                    $currentApprovalOrderNumber = $lastMember->approval_order;
                } else {
                    $currentApprovalOrderNumber = ++$lastMember->approval_order;
                }
                $projetKomite = ProjectKomite::create([
                    'karyawan_id' => $request->input("daftar_kary"),
                    'approval_order' => $currentApprovalOrderNumber,
                    'updated_by' => auth()->id(),
                    'created_by' => auth()->id(),
                    'active' => 1,
                ]);

                $messages['success'] = 'Anggota Komite berhasil ditambahkan';

            }

        } catch(\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat menginput anggota komite.';
        }


        return redirect()
            ->route(
                $redirectParams['route'],
                $redirectParams['args'])
            ->with($messages);
    }

    public function updateKomiteOrder(Request $request)
    {
        $redirectParams = [
            'route' => 'Komite.index',
            'args' => [],
        ];

        try {

            dd($request->input());
            if($request->has('update_order')){

            }

            // $updateKomite = ProjectKomite::where('karyawan_id', $request->input("daftar_kary"))
            //         ->update([
            //             'approval_order' => $request->has('update_order') ? $request->input('update_order') : $isKomiteExist->first()->approval_order,
            //             'updated_by' => auth()->id(),
            //             'active' => $request->has('status') ? $request->input('status') : $isKomiteExist->first()->active,
            //         ]);

        } catch(\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat update urutan anggota komite.';
        }
    }


    public function getActiveProjectAsOptions(){
        try {
            $project = Project::where('status_id', 4)->select(['id','name'])->get();
            return response()->json([
                'data' => $project
            ]);
        } catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function surveyRequestApproval(){
        try {
             return view('components.tender.survey-request.form',
            compact([])
             // compact(
            //     'komiteDanApproval',
            //     'project',
            //     'projectId'
            // )
        );
        } catch(\Exception $e){

        }
    }
}
