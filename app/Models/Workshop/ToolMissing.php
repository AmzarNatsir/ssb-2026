<?php

namespace App\Models\Workshop;

use App\Models\HRD\KaryawanModel;
use App\Repository\Workshop\Traits\WorkshopTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolMissing extends Model
{
    use SoftDeletes, WorkshopTrait;

    protected $table = 'tool_missing';
    protected $fillable = [
        'tool_usage_id', 'date', 'reason', 'user_id'
    ];

    public function details()
    {
        return $this->hasMany(ToolMissingItems::class, 'tool_missing_id', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'user_id', 'id');
    }

    public function tool_usage()
    {
        return $this->belongsTo(ToolUsage::class, 'tool_usage_id', 'id');
    }

    public function toolHistory()
    {
        return $this->morphMany(ToolHistory::class, 'toolHistory', 'type', 'type_id');
    }
}
