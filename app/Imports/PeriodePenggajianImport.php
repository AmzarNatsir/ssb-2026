<?php

namespace App\Imports;

use App\Models\HRD\PayrollModel;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class PeriodePenggajianImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $row)
    {
        foreach($row as $row) {
            if(!empty($row["id_karyawan"])) {
                $dataExisting = PayrollModel::where('id_karyawan', $row["id_karyawan"])
                        ->where('bulan', $row["bulan"])
                        ->where('tahun', $row["tahun"])->count();
                if($dataExisting==0) {
                    $data = [
                        "id_karyawan" => $row["id_karyawan"],
                        "id_departemen" => $row["id_departemen"],
                        "bulan" => $row["bulan"],
                        "tahun" => $row["tahun"],
                        "gaji_pokok" => (empty($row['gaji_pokok'])) ? 0 : $row['gaji_pokok'],
                        "gaji_bpjs" => (empty($row['gaji_bpjs'])) ? 0 : $row['gaji_bpjs'],
                        "tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "tunj_tetap" => (empty($row['tunj_tetap'])) ? 0 : $row['tunj_tetap'],
                        "hours_meter" => (empty($row['hours_meter'])) ? 0 : $row['hours_meter'],
                        "lembur" => (empty($row['lembur'])) ? 0 : $row['lembur'],
                        "bonus" => (empty($row['bonus'])) ? 0 : $row['bonus'],
                        "bpjsks_perusahaan" => (empty($row['bpjsks_perusahaan'])) ? 0 : $row['bpjsks_perusahaan'],
                        "bpjstk_jht_perusahaan" => (empty($row['bpjstk_jht_perusahaan'])) ? 0 : $row['bpjstk_jht_perusahaan'],
                        "bpjstk_jp_perusahaan" => (empty($row['bpjstk_jp_perusahaan'])) ? 0 : $row['bpjstk_jp_perusahaan'],
                        "bpjstk_jkm_perusahaan" => (empty($row['bpjstk_jkm_perusahaan'])) ? 0 : $row['bpjstk_jkm_perusahaan'],
                        "bpjstk_jkk_perusahaan" => (empty($row['bpjstk_jkk_perusahaan'])) ? 0 : $row['bpjstk_jkk_perusahaan'],
                        "gaji_bruto" => (empty($row['gaji_bruto'])) ? 0 : $row['gaji_bruto'],
                        "bpjsks_karyawan" => (empty($row['bpjsks_karyawan'])) ? 0 : $row['bpjsks_karyawan'],
                        "bpjstk_jht_karyawan" => (empty($row['bpjstk_jht_karyawan'])) ? 0 : $row['bpjstk_jht_karyawan'],
                        "bpjstk_jp_karyawan" => (empty($row['bpjstk_jp_karyawan'])) ? 0 : $row['bpjstk_jp_karyawan'],
                        "bpjstk_jkm_karyawan" => (empty($row['bpjstk_jkm_karyawan'])) ? 0 : $row['bpjstk_jkm_karyawan'],
                        "bpjstk_jkk_karyawan" => (empty($row['bpjstk_jkk_karyawan'])) ? 0 : $row['bpjstk_jkk_karyawan'],
                        "pot_sedekah" => (empty($row['pot_sedekah'])) ? 0 : $row['pot_sedekah'],
                        "pot_pkk" => (empty($row['pot_pkk'])) ? 0 : $row['pot_pkk'],
                        "pot_air" => (empty($row['pot_air'])) ? 0 : $row['pot_air'],
                        "pot_rumah" => (empty($row['pot_rumah'])) ? 0 : $row['pot_rumah'],
                        "pot_toko_alif" => (empty($row['pot_toko_alif'])) ? 0 : $row['pot_toko_alif'],
                        "total_potongan" => (empty($row['total_potongan'])) ? 0 : $row['total_potongan'],
                        "pot_tunj_perusahaan" => (empty($row['tunj_bpjs'])) ? 0 : $row['tunj_bpjs'],
                        "thp" => (empty($row['thp'])) ? 0 : $row['thp'],
                        "created_at" => now(),
                        "updated_at" => now(),
                        'cetak_slip' => 0
                    ];
                    PayrollModel::insert($data);
                }
            }
        }
    }

    /**
     * Parse Excel file and return data without importing to database
     * Used for preview functionality
     *
     * @param UploadedFile $file
     * @return Collection
     */
    public function parseForPreview(UploadedFile $file): Collection
    {
        // Check if the file is valid
        if (!$file->isValid()) {
            throw new \Exception("File upload failed: " . $file->getErrorMessage());
        }

        // Store file temporarily using direct move
        $tempName = 'import_' . time() . '.' . $file->getClientOriginalExtension();
        $tempPath = storage_path('app/temp');
        
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $file->move($tempPath, $tempName);
        $fullPath = $tempPath . DIRECTORY_SEPARATOR . $tempName;

        if (!file_exists($fullPath)) {
            throw new \Exception("Failed to move uploaded file to temporary storage.");
        }

        // Detect reader type
        $extension = strtolower($file->getClientOriginalExtension());
        $readerType = null;
        if ($extension === 'xlsx') {
            $readerType = \Maatwebsite\Excel\Excel::XLSX;
        } elseif ($extension === 'csv') {
            $readerType = \Maatwebsite\Excel\Excel::CSV;
        }

        // Log the path for debugging
        \Log::info("Excel Preview Path: " . $fullPath);

        try {
            // Use Excel::toArray() with the absolute stored path
            // Using an empty array as first argument for a 'plain' array import
            $data = Excel::toArray([], $fullPath, null, $readerType);

            // Clean up: delete the temporary file after successful parse
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Flatten the data (toArray returns an array of sheets)
            $rows = $data[0] ?? [];
        } catch (\Exception $e) {
            // Clean up on failure as well
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            throw new \Exception("Excel library error: " . $e->getMessage());
        }

        if (empty($rows)) {
            return collect();
        }

        // First row is the header
        $headerRow = array_shift($rows);

        // Convert header to lowercase keys for consistency
        $headers = array_map(function($header) {
            return strtolower(trim($header));
        }, $headerRow);

        $parsedData = collect();

        foreach ($rows as $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Combine headers with row values
            $rowData = [];
            foreach ($headers as $index => $header) {
                $rowData[$header] = $row[$index] ?? null;
            }

            $parsedData->push([
                'id_karyawan' => $rowData['id_karyawan'] ?? null,
                'bulan' => $rowData['bulan'] ?? null,
                'tahun' => $rowData['tahun'] ?? null,
                'nik' => $rowData['nik'] ?? null,
                'nama_karyawan' => $rowData['nama_karyawan'] ?? null,
                'posisi' => $rowData['posisi'] ?? null,
                'id_departemen' => $rowData['id_departemen'] ?? null,
                'departemen' => $rowData['departemen'] ?? null,
                'status_karyawan' => $rowData['status_karyawan'] ?? null,
                'tgl_masuk' => $rowData['tgl_masuk'] ?? null,
                'lama_bekerja' => $rowData['lama_bekerja'] ?? null,
                'gaji_pokok' => $rowData['gaji_pokok'] ?? 0,
                'gaji_bpjs' => $rowData['gaji_bpjs'] ?? 0,
                'tunj_bpjs' => $rowData['tunj_bpjs'] ?? 0,
                'tunj_tetap' => $rowData['tunj_tetap'] ?? 0,
                'hours_meter' => $rowData['hours_meter'] ?? 0,
                'bonus' => $rowData['bonus'] ?? 0,
                'lembur' => $rowData['lembur'] ?? 0,
                'bpjsks_perusahaan' => $rowData['bpjsks_perusahaan'] ?? 0,
                'bpjstk_jht_perusahaan' => $rowData['bpjstk_jht_perusahaan'] ?? 0,
                'bpjstk_jp_perusahaan' => $rowData['bpjstk_jp_perusahaan'] ?? 0,
                'bpjstk_jkm_perusahaan' => $rowData['bpjstk_jkm_perusahaan'] ?? 0,
                'bpjstk_jkk_perusahaan' => $rowData['bpjstk_jkk_perusahaan'] ?? 0,
                'gaji_bruto' => $rowData['gaji_bruto'] ?? 0,
                'bpjsks_karyawan' => $rowData['bpjsks_karyawan'] ?? 0,
                'bpjstk_jht_karyawan' => $rowData['bpjstk_jht_karyawan'] ?? 0,
                'bpjstk_jp_karyawan' => $rowData['bpjstk_jp_karyawan'] ?? 0,
                'bpjstk_jkm_karyawan' => $rowData['bpjstk_jkm_karyawan'] ?? 0,
                'bpjstk_jkk_karyawan' => $rowData['bpjstk_jkk_karyawan'] ?? 0,
                'pot_sedekah' => $rowData['pot_sedekah'] ?? 0,
                'pot_pkk' => $rowData['pot_pkk'] ?? 0,
                'pot_air' => $rowData['pot_air'] ?? 0,
                'pot_rumah' => $rowData['pot_rumah'] ?? 0,
                'pot_toko_alif' => $rowData['pot_toko_alif'] ?? 0,
                'total_potongan' => $rowData['total_potongan'] ?? 0,
                'thp' => $rowData['thp'] ?? 0,
            ]);
        }

        return $parsedData;
    }
}
