<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\Project;
use App\Models\Tender\Auction;

class AuctionController extends Controller
{
    public function index()
    {
    	return view('Tender.jampel.index');
    }

    public function store(Project $project, Request $request)
    {

    	$redirectParams = [
    		'route' => 'bond.index',
    		'args' => [],
    	];

    	try {

	    	$bond = Auction::create([
	    		'project_id' => $request->project_id,
	    		'user_id' => auth()->id(),
	    		'assignment_number' => $request->assignment_number,
	    		'bond_date' => $request->bond_date,
	    		'bond_amount' => $request->bond_amount,
	    		'bond_start_date' => $request->bond_start_date,
	    		'bond_end_date' => $request->bond_end_date,
	    		'bank_name' => $request->bank_name,
	    		'bond_number' => $request->bond_number,
	    	]);

    		$messages['success'] = 'Data Dokumen Tahap I berhasil disimpan';

    	} catch(\Illuminate\Database\QueryException $ex){
    		$messages['danger'] = 'Error pada saat menginput data Dokumen Tahap I';
    	}

    	return redirect()->route(
                $redirectParams['route'],
                $redirectParams['args']
              )->with($messages);
    }
}
