<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\MemoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as OA;

class HrdApiController extends Controller
{
    #[OA\Get(
        path: '/hrd/profile/{id}',
        summary: 'Get employee profile by ID',
        tags: ['HRD'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Employee ID',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'data', type: 'object')
            ]
        )
    )]
    #[OA\Response(response: 403, description: 'Unauthorized access')]
    #[OA\Response(response: 404, description: 'Employee not found')]
    public function getProfile($id)
    {
        $karyawan = KaryawanModel::with(['get_departemen', 'get_divisi', 'get_jabatan'])->find($id);

        if (!$karyawan) {
            return response()->json(['status' => 'error', 'message' => 'Employee not found'], 404);
        }

        $this->authorize('view', $karyawan);

        return response()->json([
            'status' => 'success',
            'data' => $karyawan->only([
                'id', 'nik', 'nm_lengkap', 'tmp_lahir', 'tgl_lahir', 'jenkel', 
                'alamat', 'notelp', 'nmemail', 'agama', 'id_divisi', 'id_departemen', 'id_jabatan'
            ])
        ]);
    }

    #[OA\Get(
        path: '/hrd/photo/{id}',
        summary: 'Get employee photo by ID',
        tags: ['HRD'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Employee ID',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        headers: [
            new OA\Header(header: 'Content-Type', description: 'image/jpeg', schema: new OA\Schema(type: 'string'))
        ]
    )]
    #[OA\Response(response: 403, description: 'Unauthorized access')]
    #[OA\Response(response: 404, description: 'Photo not found')]
    public function getPhoto($id)
    {
        $karyawan = KaryawanModel::find($id);

        if (!$karyawan || !$karyawan->photo) {
            return response()->json(['status' => 'error', 'message' => 'Photo not found'], 404);
        }

        $this->authorize('view', $karyawan);

        $path = storage_path('app/public/hrd/photo/' . $karyawan->photo);

        if (!file_exists($path)) {
            return response()->json(['status' => 'error', 'message' => 'File does not exist on server'], 404);
        }

        return response()->file($path);
    }

    #[OA\Get(
        path: '/hrd/memo/{id}',
        summary: 'Get internal memo document by ID',
        tags: ['HRD'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Memo ID',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful operation',
        headers: [
            new OA\Header(header: 'Content-Type', description: 'application/pdf', schema: new OA\Schema(type: 'string'))
        ]
    )]
    #[OA\Response(response: 403, description: 'Unauthorized access or inactive memo')]
    #[OA\Response(response: 404, description: 'Memo not found')]
    public function getMemo($id)
    {
        $memo = MemoModel::find($id);

        if (!$memo) {
            return response()->json(['status' => 'error', 'message' => 'Memo not found'], 404);
        }

        $this->authorize('view', $memo);

        $path = storage_path('app/public/memo_internal/' . $memo->file_memo);

        if (!file_exists($path)) {
            return response()->json(['status' => 'error', 'message' => 'File does not exist on server'], 404);
        }

        return response()->file($path);
    }
}
