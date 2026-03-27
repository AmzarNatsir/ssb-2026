<?php

namespace App\Imports;

use App\Models\HRD\AbsensiModel;
use App\Models\HRD\KaryawanModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AbsensiImport implements WithMultipleSheets
{
    protected $sheetInstances = [];
    public function sheets(): array
    {
         $this->sheetInstances = [
            'Daftar Kehadiran Karyawan' => new KehadiranImport()
        ];

        return $this->sheetInstances;
    }

    public function getErrors()
    {
        return array_merge(
            $this->sheetInstances['Daftar Kehadiran Karyawan']->getErrors()
        );
    }

    public function isAllValid(): bool
    {
        foreach ($this->sheetInstances as $sheet) {
            foreach ($sheet->getRows() as $row) {
                if (!$row['valid']) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getValidationSummary(): array
    {
        $summary = [];

        foreach ($this->sheetInstances as $sheetName => $sheet) {
            foreach ($sheet->getRows() as $row) {
                if (!($row['valid'] ?? false)) {
                    $summary[] = [
                        'sheet' => $sheetName,
                        'row' => $row['row_number'] ?? null,
                        'errors' => $row['errors'] ?? [],
                    ];
                }
            }
        }

        return $summary;
    }

    public function saveAllToDB()
    {
        foreach ($this->sheetInstances['Daftar Kehadiran Karyawan']->getRows() as $row) {
            $nik_lama = $row['nik_lama'] ?? null;
            if (!$nik_lama) continue;

            $getDept = KaryawanModel::where('nik_lama', $row["nik_lama"])->first();
            if(!empty($getDept->id_departemen))
            {
                // dd($row);
                $tanggal_scan = $row['tanggal'];
                $temp_waktu_scan = $row['jam'];
                AbsensiModel::create([
                    "id_departemen" => $getDept->id_departemen,
                    "nik_lama" => $row['nik_lama'],
                    "tanggal" => $tanggal_scan, //$row['tglwaktu'],
                    "jam" => $temp_waktu_scan, //$row['tglwaktu'],
                    "status" => $row['i_o'],
                    "lokasi_id" => $row['lokasi_id'],
                    "user_id" => auth()->user()->id,
                    "dhuhur" => $row['dhuhur'],
                    'ashar' => $row['ashar']
                ]);
            }

        }

    }

    public function getValidationDate()
    {
        $importedDates = collect($this->sheetInstances['Daftar Kehadiran Karyawan']->getRows()) // ambil data hasil parsing
            ->pluck('tanggal')
            ->unique();

        $existingDates = AbsensiModel::whereIn('tanggal', $importedDates)
            ->pluck('tanggal')
            ->toArray();

        return $existingDates;
    }
}
