<?php

namespace App\Traits;

trait ExcelRowValidator
{
    /**
     * Validasi apakah field berisi ID yang ada di model.
     */
    public function validateMasterId($modelClass, $fieldValue, $label)
    {
        if (!$fieldValue || !$modelClass::find($fieldValue)) {
            return "'ID $label '$fieldValue' tidak ditemukan di master ".$label;
        }
        return null;
    }

    /**
     * Validasi apakah nilai termasuk dalam enum/daftar referensi.
     */
    public function validateEnum($fieldValue, $label, $allowedValues)
    {
        $allowed = array_map('strtolower', array_map('trim', $allowedValues));
        $value = strtolower(trim($fieldValue ?? ''));

        if (!in_array($value, $allowed)) {
            if(empty(!$fieldValue)) {
                return "$label kosong dan tidak valid. Gunakan salah satu: " . implode(', ', $allowedValues);
            } else {
                return "$label '$fieldValue' tidak valid. Gunakan salah satu: " . implode(', ', $allowedValues);
            }
        }

        return null;
    }

    /**
     * Validasi field required.
     */
    public function validateRequired($fieldValue, $label)
    {
        if (trim($fieldValue ?? '') === '') {
            return "$label wajib diisi.";
        }
        return null;
    }

    private function validateDateFormat($value, $fieldName, $format = 'Y-m-d')
    {
        if (!$value) return null;

        $d = \DateTime::createFromFormat($format, $value);
        $valid = $d && $d->format($format) === $value;

        return $valid ? null : "$fieldName harus dalam format $format.";
    }

    private function validateTimeFormat($value, $fieldName, $format = 'H:i')
    {
        if (!$value) return null;

        $t = \DateTime::createFromFormat($format, $value);
        $valid = $t && $t->format($format) === $value;

        return $valid ? null : "$fieldName harus dalam format $format.";
    }
}
