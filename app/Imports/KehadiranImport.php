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

            // Convert numeric dates from Excel if needed
            $tanggal = $row['tanggal'] ?? null;
            if (is_numeric($tanggal)) {
                try {
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
                    $rowData['tanggal'] = $tanggal;
                } catch (\Exception $e) {}
            }

            // Convert numeric time from Excel if needed (stored as decimal fraction of day)
            $jam = $row['jam'] ?? null;
            if (is_numeric($jam)) {
                try {
                    $timeValue = floatval($jam);
                    if ($timeValue > 0 && $timeValue < 1) {
                        $seconds = $timeValue * 86400; // 24 * 60 * 60
                        $hours = intval($seconds / 3600);
                        $minutes = intval(($seconds % 3600) / 60);
                        $jam = sprintf('%02d:%02d', $hours, $minutes);
                        $rowData['jam'] = $jam;
                    }
                } catch (\Exception $e) {}
            }

            // Validasi required fields
            if ($msg = $this->validateRequired($tanggal ?? null, 'Tanggal')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            } elseif ($msg = $this->validateDateFormat($tanggal, 'Tanggal')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            }

            if ($msg = $this->validateRequired($jam ?? null, 'Jam')) {
                $errorMessages[] = "Tab 1 - Baris {$rowNumber}: $msg";
            } elseif ($msg = $this->validateTimeFormat($jam, 'Jam')) {
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
