<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender\ProjectKomite;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;

class KomiteController extends Controller
{
    public function index(){

    	$breadcrumb = array(
    		array("item" => "Dashboard", "url" => url('/')),
    		array("item" => "Project Management", "url" => null ),
    		array("item" => "Komite", "url" => null)
    	);

    	$projectKomite = ProjectKomite::with('karyawan')
    						->orderBy('approval_order')->get();

        $opsiDepartemen = DepartemenModel::orderBy('nm_dept', 'asc')->get();
        $opsiJabatan = JabatanModel::orderBy('nm_jabatan', 'asc')->get();
        $opsiKaryawan = KaryawanModel::where('id_status_karyawan', 3)
        					->orderBy('nm_lengkap', 'asc')->get(); 
        
        return view('Tender.komite.index', 
        	compact('breadcrumb','projectKomite','opsiDepartemen','opsiJabatan','opsiKaryawan')
        );
    }

    public function loadDataTable()
    {
        $komite = ProjectKomite::with(
            'karyawan',
            'karyawan.get_departemen',
            'karyawan.get_jabatan'
        )        
        ->orderBy('approval_order')->get();
        return response()->json([
            'data' => $komite
        ]);
    }

    public function deleteMember(Request $Request, $memberId){        
        try {
            
            $deleteMember = ProjectKomite::destroy($memberId);
            $status = 1;
            $messages = 'Komite berhasil dihapus';

        } catch(\Illuminate\Database\QueryException $ex){
            
            dd($ex->getMessage());
            $status = 0;
            $messages = 'Error pada saat menghapus anggota komite.';
        }

        return response()->json([
            'status' => $status,
            'message' => $messages
        ]);
    }

    public function reorderKomiteMember(Request $request)
    {

        $redirectParams = [
          'route' => 'Komite.index',
          'args' => [],
        ];        

        try {
          
          if( !empty($request->input('member_id')) && count($request->input('member_id')) > 0){
            foreach ($request->input('member_id') as $key => $value) {
                
                $updatedColumns = array(
                  'approval_order' => $request->input('member_new_position')[$key]
                );

                // \DB::connection()->enableQueryLog();
                $updateOrder = ProjectKomite::where('id', $value)->update($updatedColumns);                                
                // dd(\DB::getQueryLog());                
            }
          } else {
            $messages['danger'] = 'Error pada saat reorder member. silahkan ulangi kembali';
          }
            

        } catch(\Illuminate\Database\QueryException $ex){
            dd($ex->getMessage());
            $messages['danger'] = 'Error pada saat reorder member.';
        }

        $messages['success'] = 'Perubahan order/urutan komite berhasil!';

        return redirect()->route(
                $redirectParams['route'], 
                $redirectParams['args'])
            ->with($messages);
              
    }


}
