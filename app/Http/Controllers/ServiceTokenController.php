<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class ServiceTokenController extends Controller
{
    /**
     * @OA\Get(
     *   path="/admin/service-token",
     *   summary="List semua service token aktif",
     *   description="Menampilkan daftar semua permanent service token yang telah digenerate untuk aplikasi eksternal.",
     *   tags={"Service Token"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Daftar service token",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(
     *           @OA\Property(property="id", type="integer", example=5),
     *           @OA\Property(property="app_name", type="string", example="Aplikasi HRD External"),
     *           @OA\Property(property="nik", type="string", example="001"),
     *           @OA\Property(property="abilities", type="array", @OA\Items(type="string"), example={"*"}),
     *           @OA\Property(property="last_used_at", type="string", nullable=true, example="2026-05-15 08:00:00"),
     *           @OA\Property(property="created_at", type="string", example="2026-05-15 07:00:00")
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $tokens = DB::table('personal_access_tokens')
            ->select('id', 'tokenable_id', 'name', 'abilities', 'last_used_at', 'created_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($token) {
                $user = User::find($token->tokenable_id);
                return [
                    'id'           => $token->id,
                    'app_name'     => $token->name,
                    'nik'          => $user?->nik ?? '-',
                    'abilities'    => json_decode($token->abilities, true),
                    'last_used_at' => $token->last_used_at,
                    'created_at'   => $token->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $tokens,
        ]);
    }

    /**
     * @OA\Post(
     *   path="/admin/service-token",
     *   summary="Generate permanent service token",
     *   description="Membuat token permanen untuk aplikasi eksternal. Token hanya ditampilkan sekali - simpan segera.",
     *   tags={"Service Token"},
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nik", "app_name"},
     *       @OA\Property(property="nik", type="string", description="NIK user / service account", example="001"),
     *       @OA\Property(property="app_name", type="string", description="Nama aplikasi yang memakai token", example="Aplikasi HRD External"),
     *       @OA\Property(
     *         property="abilities",
     *         type="array",
    *         description="Hak akses token. Default [*] berarti semua akses.",
     *         @OA\Items(type="string"),
     *         example={"*"}
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Token berhasil dibuat",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Service token berhasil dibuat. Simpan token ini - tidak akan ditampilkan lagi."),
     *       @OA\Property(property="token_id", type="integer", example=5),
     *       @OA\Property(property="app_name", type="string", example="Aplikasi HRD External"),
     *       @OA\Property(property="nik", type="string", example="001"),
     *       @OA\Property(property="abilities", type="array", @OA\Items(type="string"), example={"*"}),
     *       @OA\Property(property="access_token", type="string", example="5|AbCdEfGhIj..."),
     *       @OA\Property(property="token_type", type="string", example="Bearer")
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik'       => 'required|string|exists:users,nik',
            'app_name'  => 'required|string|max:100',
            'abilities' => 'sometimes|array',
            'abilities.*' => 'string',
        ]);

        $user      = User::where('nik', $request->nik)->firstOrFail();
        $abilities = $request->input('abilities', ['*']);
        $appName   = $request->input('app_name');

        $newToken = $user->createToken($appName, $abilities);

        return response()->json([
            'success'      => true,
            'message'      => 'Service token berhasil dibuat. Simpan token ini — tidak akan ditampilkan lagi.',
            'token_id'     => $newToken->accessToken->id,
            'app_name'     => $appName,
            'nik'          => $user->nik,
            'abilities'    => $abilities,
            'access_token' => $newToken->plainTextToken,
            'token_type'   => 'Bearer',
        ], 201);
    }

    /**
     * @OA\Delete(
     *   path="/admin/service-token/{id}",
     *   summary="Cabut (revoke) service token",
     *   description="Menghapus permanent service token berdasarkan ID. Aplikasi yang memakai token ini tidak akan bisa akses API lagi.",
     *   tags={"Service Token"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID token (dari kolom id tabel personal_access_tokens)",
     *     @OA\Schema(type="integer", example=5)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Token berhasil dicabut",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Token ID 5 berhasil dicabut.")
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Token tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $deleted = DB::table('personal_access_tokens')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Token ID {$id} berhasil dicabut.",
        ]);
    }
}
