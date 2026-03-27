<?php
namespace App\Traits;

trait Payroll
{
    public static function getPotTunjBpjs($gapok, $persen)
    {
        $result = ($gapok * $persen) / 100;
        return $result;
    }
}
