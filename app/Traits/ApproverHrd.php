<?php
namespace App\Traits;

use App\Helpers\Hrdhelper;
use App\Models\HRD\ApprovalModel;

trait ApproverHrd
{

    public static function countLevel($key)
    {
        $countLevel = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $key)->orderBy('approval_level')->get()->count();
        return $countLevel;
    }

    public static function listApprover($key)
    {
        $countLevel = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $key)->orderBy('approval_level')->get()->count();
        $queryResult = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $key)->orderBy('approval_level')->limit($countLevel - 1)->get();
        return $queryResult;
    }

    public static function listKnowing($key)
    {
        $queryResult = ApprovalModel::with(['get_profil_employee'])->where('approval_key', $key)->orderBy('approval_level', 'desc')->limit(1)->first();
        return $queryResult;
    }

}
