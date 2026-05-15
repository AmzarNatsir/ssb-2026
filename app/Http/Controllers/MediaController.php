<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class MediaController extends Controller
{
    #[OA\Get(
        path: '/media/photo/{filename}',
        summary: 'Get foto karyawan',
        description: 'Mengambil file foto karyawan dari folder storage/app/public/hrd/photo. Memerlukan service token.',
        tags: ['Media'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Parameter(
        name: 'filename',
        in: 'path',
        required: true,
        description: 'Nama file foto (contoh: foto_001.jpg)',
        schema: new OA\Schema(type: 'string', example: 'foto_001.jpg')
    )]
    #[OA\Response(response: 200, description: 'File binary (image)')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 404, description: 'File tidak ditemukan')]
    public function getPhoto($filename)
    {
        return $this->serveFile('hrd/photo', $filename);
    }

    #[OA\Get(
        path: '/media/memo-internal/{filename}',
        summary: 'Get file memo internal',
        description: 'Mengambil file memo internal dari folder storage/app/public/memo_internal. Memerlukan service token.',
        tags: ['Media'],
        security: [['bearerAuth' => []]],
    )]
    #[OA\Parameter(
        name: 'filename',
        in: 'path',
        required: true,
        description: 'Nama file memo (contoh: memo_001.pdf)',
        schema: new OA\Schema(type: 'string', example: 'memo_001.pdf')
    )]
    #[OA\Response(response: 200, description: 'File binary (pdf/image)')]
    #[OA\Response(response: 401, description: 'Unauthenticated')]
    #[OA\Response(response: 404, description: 'File tidak ditemukan')]
    public function getMemoInternal($filename)
    {
        return $this->serveFile('memo_internal', $filename);
    }

    private function serveFile(string $folder, string $filename)
    {
        // Cegah path traversal
        $filename = basename($filename);

        $path = storage_path("app/public/{$folder}/{$filename}");

        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.',
            ], 404);
        }

        return response()->file($path);
    }
}
