<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\Bond;
use App\Models\Tender\Auction;
use App\Models\Tender\WorkAssignment;
use App\Models\Tender\Files;
use App\Models\Tender\FileTypes;
use App\Models\HRD\KaryawanModel;
use Storage;
use File;

class JampelController extends Controller
{
    public function index()
    {
    	return view('Tender.jampel.index');
    }

    public function loadDataTable()
    {

    	$bond = Project::with([
    		'category' => function ($query){
    			$query->select('keterangan','id');
        },
        'status' => function ($query){
        	$query->select('keterangan','id');
        },
        'type' => function ($query){
        	$query->select('keterangan','id');
        },
    	])->select('id','name','created_at','value','status_id','category_id','tipe_id','location')
    	->whereNotIn('tipe_id', [3,4])
    	->orderBy('created_at')
    	->get();

    	return response()->json([
    		'data' => $bond
    	]);
    }

    public function create($projectId)
    {

    	$bond = Bond::where('project_id', $projectId)->first();
    	$auctionPhase1 = Auction::where('project_id', $projectId)->withPhaseNumber(1)->first();
    	$auctionPhase2 = Auction::where('project_id', $projectId)->withPhaseNumber(2)->first();
    	$workAssignment = WorkAssignment::where('project_id', $projectId)->first();

        // dokumen tahap 1
		$fileTypesPhase1 = FileTypes::when( isset($auctionPhase1->id), function($q) use ($auctionPhase1)
        {
  				$q->leftJoin('auction_file', 'file_types.id', '=', 'auction_file.file_types_id')
  					->where('auction_file.auction_id', $auctionPhase1->id)
  					->orWhereNull('auction_file.auction_id')
  					->selectRaw('file_types.id, file_types.name, auction_file.file_types_id');
  			})
  			->whereIn('file_types_category_id', [1, 4])
  			->when(!isset($auctionPhase1->id), function ($q)
          {
  				  $q->selectRaw("file_types.id, file_types.name, NULL AS 'file_types_id'");
          }
        )->get()->toArray();

        // dokumen tahap 2
        $fileTypesPhase2 = FileTypes::when( isset($auctionPhase2->id), function($q) use ($auctionPhase2)
            {
            $q->leftJoin('auction_file', 'file_types.id', '=', 'auction_file.file_types_id')
                ->where('auction_file.auction_id', $auctionPhase2->id)
                ->orWhereNull('auction_file.auction_id')
                ->selectRaw('file_types.id, file_types.name, auction_file.file_types_id');
            })
            ->whereIn('file_types_category_id', [1, 4])
            ->when(!isset($auctionPhase2->id), function ($q)
            {
                $q->selectRaw("file_types.id, file_types.name, NULL AS 'file_types_id'");
            }
            )->get()->toArray();


        $phase2Files = Project::where(['id' => $projectId,])
            ->with(['files' => function ($query){
                $query->whereHas('filetype', function ($subquery){
                    $subquery->where('id', 2);
                });
            }])->first();

        $masterFileTypes = FileTypes::whereIn('file_types_category_id', [1, 4])->get()->toArray();


    	$userOptions = KaryawanModel::where('id_status_karyawan','<=', 3)
    		->orderBy('nm_lengkap', 'asc')
    		->select('id','nm_lengkap')
    		->get();

        $userId = auth()->id();

    	return view('components.tender.jampel.form',
    		compact(
                'projectId',
                'bond',
                'workAssignment',
                'fileTypesPhase1',
                'fileTypesPhase2',
                'auctionPhase1',
                'auctionPhase2',
                'userOptions',
                'masterFileTypes',
                'userId',
                'phase2Files'
            )
        );
    }

    public function store(Project $project, Request $request)
    {

    	$redirectParams = [
    		'route' => 'bond.index',
    		'args' => [],
    	];

    	try {

	    	$bond = Bond::updateOrCreate(
                ['project_id' => $request->project_id]
                ,[
    	    		'project_id' => $request->project_id,
    	    		'user_id' => auth()->id(),
    	    		'letter_no' => $request->assignment_number,
    	    		'bond_date' => $request->bond_date,
    	    		'bond_amount' => str_replace(',','',$request->bond_amount),
    	    		'bond_start_date' => $request->bond_start_date,
    	    		'bond_end_date' => $request->bond_end_date,
    	    		'bank_name' => $request->bank_name,
    	    		'bond_number' => $request->bond_number,
    	    	]
            );

            $workAssignment = WorkAssignment::updateOrCreate(
                ['project_id' => $request->project_id],
                [
                    'project_id' => $request->project_id,
                    'user_id' => auth()->id(),
                    'assignment_number' => $request->assignment_number,
                    'assignment_date' => $request->bond_date,
                    'assignment_amount' => str_replace(',','',$request->bond_amount)
                ]
            );

    		$messages['success'] = 'jaminan pelaksanaan berhasil disimpan';

    	} catch(\Illuminate\Database\QueryException $ex){
            dd($ex);
    		$messages['danger'] = 'Error pada saat menginput jaminan pelaksanaan';
    	}

    	return redirect()->route(
                $redirectParams['route'],
                $redirectParams['args']
              )->with($messages);
    }


    //
    public function storeAuction(Request $request)
    {

    	$redirectParams = [
    		'route' => 'bond.index',
    		'args' => [],
    	];

    	try {

            $filetypes = array();

            foreach($request->input() as $inputName => $inputValue)
            {
    			if ( substr($inputName, 0, strlen("file-")) === "file-" || substr($inputName, 0, strlen("file-2-")) === "file-2-" )
    			{
                    $filetypeid = $request->input('phase_number') == "1" ? substr($inputName, 5) : substr($inputName, 7);
    				array_push($filetypes, $filetypeid);
    			}
    		}

            // if($request->input('auction_id'))
            if($request->filled('auction_id'))
            {

                $criteria = [
                    'project_id' => $request->input('project_id'),
                    'id' => $request->input('auction_id'),
                    'phase_number' => $request->input('phase_number')
                ];

            } else {

                $criteria = [
                    'project_id' => $request->input('project_id'),
                    'phase_number' => $request->input('phase_number')
                ];

            }

	    	$auction = Auction::updateOrCreate(
            $criteria, [
                'project_id' => $request->input('project_id'),
                'user_id' => auth()->id(),
                'sender_id' => $request->input('sender_id'),
                'phase_number' => $request->input('phase_number'),
                'send_date' => $request->input('send_date'),
                'accepted_document_number' => $request->input('accepted_document_number'),
                'accepted_date' => $request->input('accepted_date'),
            ]
        );

        // dd($auction);

            if($auction->wasRecentlyCreated)
            {
                foreach ($filetypes as $key => $value) {
                    $auction->filetypes()->attach($value);
                }
            } else
            {

            $arr = array();
            $dfile = $auction->filetypes()->wherePivot('auction_id', $request->input('auction_id'))->get();
            foreach ($dfile as $dfile) {
                array_push($arr, $dfile->pivot->file_types_id);
            }

                $auction->filetypes()->detach(array_diff($arr, $filetypes));
            }

            if($request->hasfile('quotation_letter_id') || $request->hasfile('lampiran_lain'))
            {
                if($request->file('quotation_letter_id')->isValid())
                {

                    $filetype = FileTypes::where('file_types_category_id', 2)
                        ->where('name', 'LIKE', '%penawaran harga%')
                        ->first();

                    $randomName = round(microtime(true) * 1000);
                    $filename = $randomName.'-'.str_replace(' ','-',$request->file('quotation_letter_id')->getClientOriginalName());
                    $upload = Files::create([ 'name' => $filename, 'file_types_id' => $filetype->id ]);
                    $project = Project::find($request->input('project_id'));

                    // aktifasi project
                    if($request->input('phase_number') == "2"){
                        $project->status_id = 4;
                    }

                    $project->files()->attach($upload);
                    $project->save();

                    Storage::disk('public')->put('/project/'.$filename, File::get($request->file('quotation_letter_id')));
                }

                if($request->file('lampiran_lain')->isValid())
                {
                    $filetype = FileTypes::where('file_types_category_id', 4)
                        ->where('name', 'LIKE', '%lampiran lain%')
                        ->first();

                    $randomName = round(microtime(true) * 1000);
                    $filename = $randomName.'-'.str_replace(' ','-',$request->file('lampiran_lain')->getClientOriginalName());
                    $upload = Files::create([ 'name' => $filename, 'file_types_id' => $filetype->id ]);
                    $project = Project::find($request->input('project_id'));

                    // aktifasi project
                    if($request->input('phase_number') == "2"){
                        $project->status_id = 4;
                    }

                    $project->files()->attach($upload);
                    $project->save();

                    Storage::disk('public')->put('/project/'.$filename, File::get($request->file('lampiran_lain')));

                }
            }

    		$messages["success"] = "sukses auction";

    	} catch(\Illuminate\Database\QueryException $ex){
    		dd($ex);
    		$messages['danger'] = 'Error pada saat input Dokumen Tahap '.$request->input('phase_number');
    	}

    	return redirect()->route(
    		$redirectParams['route'],
    		$redirectParams['args']
    	)->with($messages);

    }

    public function updateAuction(Request $request)
    {

    	$redirectParams = [
    		'route' => 'bond.index',
    		'args' => [],
    	];

    	try {

            // dd($request->all());

	    	$filetypes = array();
    		foreach($request->input() as $inputName => $inputValue)
            {
                if (substr($inputName, 0, strlen("file-")) === "file-" || substr($inputName, 0, strlen("file-2-")) === "file-2-")
				{
					$filetypeid = $request->input('phase_number') == "1" ? substr($inputName, 5) : substr($inputName, 7);
    				array_push($filetypes, $filetypeid);
    			}
    		}

	    	$auction = Auction::find($request->input('auction_id'));
	    	$auction->user_id = auth()->id();
	    	$auction->send_date = $request->input('send_date');
	    	$auction->sender_id = $request->input('sender_id');
	    	$auction->accepted_document_number = $request->input('accepted_document_number');
	    	$auction->accepted_date = $request->input('accepted_date');
	    	$auction->save();
	    	$auction->filetypes()->sync($filetypes);

	    	if($request->hasfile('quotation_letter_id'))
			{
                if($request->file('quotation_letter_id')->isValid())
                {

                    $filetype = FileTypes::where('file_types_category_id', 2)
                        ->where('name', 'LIKE', '%penawaran harga%')
                        ->first();

                    $randomName = round(microtime(true) * 1000);
                    $filename = $randomName.'-'.str_replace(' ','-',$request->file('quotation_letter_id')->getClientOriginalName());

                    $upload = Files::create([ 'name' => $filename, 'file_types_id' => $filetype->id ]);
                    $project = Project::find($request->input('project_id'));
                    $project->files()->attach($upload);
                    Storage::disk('public')->put('/project/'.$filename, File::get($request->file('quotation_letter_id')), 'public');
				}
			}

            // cek jika user ingin menghapus dokumen
            if($request->has(['fileIdsToBeDelete','fileNamesToBeDelete'])){

              foreach ($request->input('fileIdsToBeDelete') as $key => $arrayOfValues) {
                $fileIds = explode(",", $arrayOfValues);
                $fileNames = explode(",", $request->input('fileNamesToBeDelete')[$key]);
              }

              Files::destroy($fileIds);
              $project = Project::find($request->input('project_id'));
              $project->files()->detach($fileIds);

              foreach($fileNames as $index => $filename){
                if(Storage::disk('public')->exists('project')){
                  Storage::disk('public')->delete('project/'. $filename);
                }
              }
            }

	    	$messages["success"] = "sukses melakukan update data tender";

    	} catch(\Illuminate\Database\QueryException $ex){
    			$messages['danger'] = 'Error auction';
    	}

    	return redirect()->route(
    		$redirectParams['route'],
    		$redirectParams['args']
    	)->with($messages);


    }

    public function update(Bond $bond, Request $request){
    	dd($request->input());
    	// $bond->assignment_number = $request->assignment_number;
    	// $bond->bond_date = $request->bond_date;
    	// $bond->bond_amount = $request->bond_amount;
    	// $bond->bond_start_date = $request->bond_start_date;
    	// $bond->bond_end_date = $request->bond_end_date;
    	// $bond->bank_name = $request->bank_name;
    	// $bond->bond_number = $request->bond_number;
    	// $bond->save();
    }
}
