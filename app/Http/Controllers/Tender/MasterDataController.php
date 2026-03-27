<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\FileTypes;
use App\Models\Tender\KomiteTypes;

class MasterDataController extends Controller
{
    public function dokumen(){
    	$documents = FileTypes::orderBy('id')->get();
    	return view('Tender.master.dokumen.index', compact('documents'));
    }

    public function komite(){
    	$komiteTypes = KomiteTypes::orderBy('id')->get();
    	return view('Tender.master.komite.index', compact('komiteTypes'));
    }

    public function loadDataTable(Request $request){
    	
    }
}
