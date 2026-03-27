<?php
namespace App\Traits;

use App\Helpers\Hrdhelper;
use App\Models\HRD\KaryawanModel;

trait SubmissionHrd
{

    public static function update_current_status($id)
    {
        $update = KaryawanModel::find($id);
        $update->evaluasi_kerja = "active";
        $update->kategori_evaluasi_kerja = "pkwt_kartab";
        $update->save();
    }

    public static function update_current_mutasi($id)
    {
        $update = KaryawanModel::find($id);
        $update->evaluasi_kerja = "active";
        $update->kategori_evaluasi_kerja = "mutasi";
        $update->save();
    }
}
