<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusHeaderModel extends Model
{
    use HasFactory;
    protected $table = "hrd_bonus_header";
    protected $fillable = [
        "bulan",
        "tahun",
        "approval_key",
        "status_pengajuan",
        "current_approval_id",
        "is_draft",
        "diajukan_oleh",
    ];
}
