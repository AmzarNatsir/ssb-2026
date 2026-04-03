<?php

namespace App\Services;

use App\Models\HRD\PayrollModel;
use Illuminate\Support\Collection;

class PayrollImportValidator
{
    /**
     * Validate a collection of payroll rows
     *
     * @param Collection $rows
     * @return array ['valid' => [], 'errors' => [], 'warnings' => []]
     */
    public function validate(Collection $rows): array
    {
        $results = [
            'all' => [],
            'valid' => [],
            'errors' => [],
            'warnings' => []
        ];

        foreach ($rows as $index => $row) {
            $validation = $this->validateRow($row, $index);
            $results['all'][$index] = $validation;

            if ($validation['status'] === 'error') {
                $results['errors'][] = array_merge(['row_index' => $index], $validation);
            } elseif ($validation['status'] === 'warning') {
                $results['warnings'][] = array_merge(['row_index' => $index], $validation);
            } else {
                $results['valid'][] = array_merge(['row_index' => $index], $validation);
            }
        }

        return $results;
    }

    /**
     * Validate a single row
     *
     * @param array $row
     * @param int $rowIndex
     * @return array ['status' => 'valid|error|warning', 'messages' => []]
     */
    public function validateRow(array $row, int $rowIndex): array
    {
        $messages = [];
        $status = 'valid';

        // Check required fields
        $requiredFields = ['id_karyawan', 'bulan', 'tahun'];

        foreach ($requiredFields as $field) {
            if (empty($row[$field])) {
                $messages[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
                $status = 'error';
            }
        }

        // If required fields are missing, return early
        if ($status === 'error') {
            return [
                'status' => $status,
                'messages' => $messages
            ];
        }

        // Validate numeric fields
        $numericFields = [
            'gaji_pokok',
            'gaji_bpjs',
            'tunj_bpjs',
            'tunj_tetap',
            'hours_meter',
            'bonus',
            'lembur',
            'bpjsks_perusahaan',
            'bpjstk_jht_perusahaan',
            'bpjstk_jp_perusahaan',
            'bpjstk_jkm_perusahaan',
            'bpjstk_jkk_perusahaan',
            'gaji_bruto',
            'bpjsks_karyawan',
            'bpjstk_jht_karyawan',
            'bpjstk_jp_karyawan',
            'bpjstk_jkm_karyawan',
            'bpjstk_jkk_karyawan',
            'pot_sedekah',
            'pot_pkk',
            'pot_air',
            'pot_rumah',
            'pot_toko_alif',
            'total_potongan',
            'thp'
        ];

        foreach ($numericFields as $field) {
            // Skip validation if field is empty (will default to 0)
            if (isset($row[$field]) && $row[$field] !== '' && $row[$field] !== null) {
                if (!is_numeric($row[$field])) {
                    $messages[] = ucfirst(str_replace('_', ' ', $field)) . ' must be a valid number';
                    $status = 'error';
                }
            }
        }

        // If there are validation errors, return early
        if ($status === 'error') {
            return [
                'status' => $status,
                'messages' => $messages
            ];
        }

        // Check for duplicates
        if ($this->isDuplicate($row)) {
            $messages[] = 'Duplicate record exists in database - will be skipped';
            $status = 'warning';
        }

        return [
            'status' => $status,
            'messages' => $messages
        ];
    }

    /**
     * Check if row is duplicate in database
     *
     * @param array $row
     * @return bool
     */
    private function isDuplicate(array $row): bool
    {
        $count = PayrollModel::where('id_karyawan', $row['id_karyawan'])
            ->where('bulan', $row['bulan'])
            ->where('tahun', $row['tahun'])
            ->count();

        return $count > 0;
    }
}
