<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\User;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/login',
        summary: 'Login dan dapatkan Bearer token',
        description: 'Autentikasi user menggunakan NIK dan password. Token yang dihasilkan digunakan sebagai Bearer token untuk endpoint yang memerlukan autentikasi.',
        tags: ['Auth'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['nik', 'password'],
            properties: [
                new OA\Property(property: 'nik', type: 'string', description: 'Nomor Induk Karyawan', example: '001'),
                new OA\Property(property: 'password', type: 'string', format: 'password', description: 'Password user', example: 'secret'),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Login berhasil',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'access_token', type: 'string', example: '1|AbCdEf...'),
                new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                new OA\Property(
                    property: 'user',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'nik', type: 'string', example: '001'),
                        new OA\Property(property: 'nm', type: 'string', example: 'Budi Santoso'),
                    ]
                ),
            ]
        )
    )]
    #[OA\Response(response: 401, description: 'NIK atau password salah')]
    #[OA\Response(response: 403, description: 'User tidak memiliki role')]
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('nik', 'password')))
        {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = User::with(['karyawan' => function ($q){
            $q->select('nik','nm_lengkap');
        }])->where('nik', $request['nik'])->firstOrFail();

        // Cek role — selain super admin wajib memiliki role
        if ($user->nik !== '999999999' && $user->roles->isEmpty()) {
            Auth::logout();
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 403);
        }

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

    #[OA\Post(
        path: '/refresh-token',
        summary: 'Refresh access token',
        description: 'Revoke the current token and issue a new one',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Response(
        response: 200,
        description: 'New token issued',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'access_token', type: 'string', example: '1|abc123...'),
                new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
            ]
        )
    )]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    public function refreshToken(Request $request)
    {
        $user = $request->user();

        // Hapus token yang sedang dipakai
        $user->currentAccessToken()->delete();

        // Buat token baru
        $newToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $newToken,
            'token_type'   => 'Bearer',
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
