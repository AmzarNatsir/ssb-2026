<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('do_upload')) {
    function do_upload(string $directory = null, $file)
    {
        $name = time();
        $file = Storage::putFile($directory ? '/public/workshop/' . $directory : 'public/workshop', $file);
        $filename = explode('/', $file);

        if ($file) {
            return 'storage' . ($directory ? '/workshop/' . $directory . '/' : 'workshop') . $filename[count($filename) - 1];
        }
    }
}

if (!function_exists('show_workshop_image')) {
    function show_workshop_image($file)
    {
        return asset($file);
    }
}

if (!function_exists('workshop_settings')) {
    function workshop_settings($key)
    {
        return \App\Repository\Workshop\SettingRepository::get($key);
    }
}

if (!function_exists('workshop_date')) {
    function workshop_date($date)
    {
        if (!$date) {
            return false;
        }
        return date('d.m.Y', strtotime($date));
    }
}

if (!function_exists('workshop_time')) {
    function workshop_time($date)
    {
        if (!$date) {
            return false;
        }
        return date('H.m', strtotime($date));
    }
}

if (!function_exists('workshop_datetime')) {
    function workshop_datetime($date)
    {
        if (!$date) {
            return false;
        }
        return date('d.m.Y H:i', strtotime($date));
    }
}

if (!function_exists('workshop_date_format')) {
    function workshop_date_format($date)
    {
        if (!$date) {
            return false;
        }
        return date('d.m.Y', strtotime($date));
    }
}
