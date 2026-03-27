<?php

namespace App\Imports;

use App\Traits\ExcelRowValidator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KehadiranImport implements ToCollection, WithHeadingRow
{
    use ExcelRowValidator;

    protected $rows = [];
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 karena heading di baris 1
            $rowData = $row->toArray();
            $rowData['row_number'] = $rowNumber;
            $rowData['valid'] = true;
            $errorMessages = [];
            // Validasi required fields
            if ($msg = $this->validateRequired($row['tanggal'] ?? null, 'Tanggal')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            } elseif ($msg = $this->validateDateFormat($row['tanggal'], 'Tanggal')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            }

            if ($msg = $this->validateRequired($row['jam'] ?? null, 'Jam')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            } elseif ($msg = $this->validateTimeFormat($row['jam'], 'Jam')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            }

            if ($msg = $this->validateRequired($row['nik_lama'] ?? null, 'NIK Lama')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            }
            if ($msg = $this->validateRequired($row['i_o'] ?? null, 'I/O')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            }
            //validasi master jenis alat

            // if ($msg = $this->validateMasterId(JenisSertifikatModel::class, $row['id_status_karyawan'], 'status karyawan')) {
            //     $errorMessages[] = "Baris {$rowNumber}: $msg";
            // }

            if (!empty($errorMessages)) {
                $rowData['valid'] = false;
                $rowData['errors'] = $errorMessages;
                $this->errors[] = implode(' ', $errorMessages);
            }

            $this->rows[] = $rowData;

        }
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
