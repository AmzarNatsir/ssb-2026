<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('nik', 'password')))
        {

            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::with(['karyawan' => function ($q){
            $q->select('nik','nm_lengkap');
        }])->where('nik', $request['nik'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => (object)[
                'id' => $user->id,
                'nik' => $user->nik,
                'nm' => $user->karyawan->nm_lengkap
            ]
        ]);

    }

    public function logout(Request $request)
    {

        // $user = request()->user(); // sama dengan Auth::user()
        $token = $request->bearerToken();
        $deleteToken = DB::table('personal_access_tokens')->where([
            'token' => $token,
            'tokenable_id' => request()->user()->id])
            ->delete();

        if($deleteToken)
        {
            return response()->json([
                'success' => true,
                'message' => 'token revoked'
            ]);

        }

    }
}
