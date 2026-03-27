<?php

if (!function_exists('warehouse_number_format')) {
    function warehouse_number_format($number = null)
    {
        return $number ? number_format($number, 2, ',', '.') : 0;
    }
}

if (!function_exists('warehouse_date_format')) {
    function warehouse_date_format($date = null)
    {
        return $date ? date('d.m.Y', strtotime($date)) : '';
    }
}

if (!function_exists('warehouse_to_double_backslash')) {
    function warehouse_to_double_backslash($string = null)
    {
        return $string ? preg_replace('/\\\\/', '\\\\\\\\', $string) : '';
    }
}
