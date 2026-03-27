<?php

namespace App\Models\HRD;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SPNonAktifModel extends Model
{
    protected $table = "hrd_sp_non_aktif";
    protected $fillable = [
        'id_sp',
        'alasan_non_aktif',
        'approval_key',
        'current_approval_id',
        'is_draft',
        'create_by',
        'sts_pengajuan',
        'created_at',
        'updated_at'
    ];

    public function getSP()
    {
        return $this->belongsTo(SuratPeringatanModel::class, 'id_sp', 'id');
    }

    public function get_current_approve()
    {
        return $this->belongsTo('App\Models\HRD\KaryawanModel', 'current_approval_id', 'id');
    }

    public function getCreateBy()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
}
