<?php

namespace App\Http\Controllers;

use App\Models\HRD\DokumenKaryawanjaModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\PelamarDokumenModel;
use App\Models\HRD\PelamarModel;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * @OA\Get(
     *   path="/media/photo/{filename}",
     *   summary="Get foto karyawan",
     *   description="Mengambil file foto karyawan dari folder storage/app/public/hrd/photo. Memerlukan service token.",
     *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file foto (contoh: foto_001.jpg)",
     *     @OA\Schema(type="string", example="foto_001.jpg")
     *   ),
     *   @OA\Response(response=200, description="File binary (image)"),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="File tidak ditemukan")
     * )
     */
    public function getPhoto($filename)
    {
        return $this->serveFile('hrd/photo', $filename);
    }

    /**
     * @OA\Get(
     *   path="/media/memo-internal/{filename}",
     *   summary="Get file memo internal",
     *   description="Mengambil file memo internal dari folder storage/app/public/memo_internal. Memerlukan service token.",
     *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file memo (contoh: memo_001.pdf)",
     *     @OA\Schema(type="string", example="memo_001.pdf")
     *   ),
     *   @OA\Response(response=200, description="File binary (pdf/image)"),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="File tidak ditemukan")
     * )
     */
    public function getMemoInternal($filename)
    {
        return $this->serveFile('memo_internal', $filename);
    }

    /**
     * @OA\Get(
     *   path="/media/hasil-evaluasi/{filename}",
     *   summary="Get file hasil evaluasi karyawan",
     *   description="Mengambil file hasil evaluasi karyawan dari folder storage/app/public/hrd/hasil_evaluasi_karyawan. Memerlukan service token.",
     *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file hasil evaluasi (contoh: evaluasi_001.pdf)",
     *     @OA\Schema(type="string", example="evaluasi_001.pdf")
     *   ),
     *   @OA\Response(response=200, description="File binary (pdf/image)"),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="File tidak ditemukan")
     * )
     */
    public function getHasilEvaluasi($filename)
    {
        return $this->serveFile('hrd/hasil_evaluasi_karyawan', $filename);
    }

    /**
     * @OA\Get(
     *   path="/media/employee/dokument/{filename}",
     *   summary="Get employee document file by filename",
     *   description="Mengambil file dokumen karyawan berdasarkan nama file. Memerlukan service token.",
        *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file dokumen karyawan (contoh: dokumen_001.pdf)",
     *     @OA\Schema(type="string", example="dokumen_001.pdf")
     *   ),
     *   @OA\Response(response=200, description="File binary"),
     *   @OA\Response(response=404, description="Document not found")
     * )
     */
    public function getDocumentEmployee($filename)
    {
        $filename = basename($filename);

        $document = DokumenKaryawanjaModel::select('id_karyawan', 'file_dokumen')
            ->where('file_dokumen', $filename)
            ->first();

        if (!$document || !$document->id_karyawan) {
            return response()->json(['status' => 'error', 'message' => 'Document not found'], 404);
        }

        $karyawan = KaryawanModel::select('id', 'nik')->find($document->id_karyawan);

        if (!$karyawan) {
            return response()->json(['status' => 'error', 'message' => 'Employee not found'], 404);
        }

        $this->authorize('view', $karyawan);

        $path = storage_path('app/public/hrd/dokumen/' . $karyawan->nik . '/' . $document->file_dokumen);

        if (!file_exists($path)) {
            return response()->json(['status' => 'error', 'message' => 'File does not exist on server'], 404);
        }

        return response()->file($path);
    }

    /**
     * @OA\Get(
     *   path="/media/recruitment/photo/{filename}",
     *   summary="Get recruitment applicant photo by filename",
     *   description="Mengambil file foto pelamar berdasarkan nama file. Memerlukan service token.",
        *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file foto pelamar (contoh: photo_001.jpg)",
     *     @OA\Schema(type="string", example="photo_001.jpg")
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=404, description="Photo not found")
     * )
     */
    public function getRecruitmentPhoto($filename)
    {
        $filename = basename($filename);

        $pelamar = PelamarModel::select('id', 'file_photo')
            ->where('file_photo', $filename)
            ->first();

        if (!$pelamar || !$pelamar->file_photo) {
            return response()->json(['status' => 'error', 'message' => 'Photo not found'], 404);
        }

        $path = storage_path('app/public/hrd/pelamar/photo/' . $pelamar->file_photo);

        if (!file_exists($path)) {
            return response()->json(['status' => 'error', 'message' => 'File does not exist on server'], 404);
        }

        return response()->file($path);
    }

    /**
     * @OA\Get(
     *   path="/media/recruitment/document/{filename}",
     *   summary="Get recruitment applicant document file by filename",
     *   description="Mengambil file dokumen pelamar berdasarkan nama file. Memerlukan service token.",
        *   tags={"Media"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="filename",
     *     in="path",
     *     required=true,
     *     description="Nama file dokumen pelamar (contoh: cv_001.pdf)",
     *     @OA\Schema(type="string", example="cv_001.pdf")
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=404, description="Document not found")
     * )
     */
    public function getRecruitmentDocument($filename)
    {
        $filename = basename($filename);

        $document = PelamarDokumenModel::select('id', 'id_dokumen', 'file_dokumen')
            ->where('file_dokumen', $filename)
            ->first();

        if (!$document || !$document->file_dokumen || !$document->id_dokumen) {
            return response()->json(['status' => 'error', 'message' => 'Document not found'], 404);
        }

        $path = storage_path('app/public/hrd/pelamar/dokumen/' . $document->id_dokumen . '/' . $document->file_dokumen);

        if (!file_exists($path)) {
            return response()->json(['status' => 'error', 'message' => 'File does not exist on server'], 404);
        }

        return response()->file($path);
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
