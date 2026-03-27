<?php

namespace App\Http\Controllers\Hse;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\JabatanModel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_role($user_id){
        $user = KaryawanModel::with('get_jabatan')->where('id', $user_id)->get();
        return response()->json($user);
    }
}
