<?php
namespace App\Traits;

use App\Helpers\Hrdhelper;

trait General
{
    public static function getLogo()
    {
        $fl_logo = Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
        return $fl_logo;
    }

}
