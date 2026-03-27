<?php

namespace App\Models\Workshop;

use App\Repository\Workshop\Traits\WorkshopTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolUsage extends Model
{
    use SoftDeletes,WorkshopTrait;

    const PAGE_LIMIT = 50;
    const STATUS_OPEN = 0;
    const STATUS_CLOSED = 1;
    const NUMBER_PREFIX = 'TU.{year}.{month}.';

    protected $table = 'tool_usage';
    protected $fillable = [
        'number', 'reference', 'reference_id', 'status', 'created_by', 'updated_by'
    ];

    public function save(array $options = [])
    {
        if (auth()->user()) {
            $user = auth()->user()->id;
            if (!$this->created_by) {
                $this->created_by = $user;
            }

            $this->updated_by = $user;
        }

        if (!$this->number) {
            $this->number = $this->generateNumber();
        }

       return  parent::save($options);
    }

    public function toolable()
    {
        return $this->morphTo('toolable', 'reference', 'reference_id');
    }

    public function details()
    {
        return $this->hasMany(ToolUsageItems::class, 'tool_usage_id','id');
    }

    public function missings()
    {
        return $this->hasMany(ToolMissing::class, 'tool_usage_id', 'id');
    }

    public function toolHistory()
    {
        return $this->morphMany(ToolHistory::class, 'toolHistory', 'type', 'type_id');
    }

    public function complete()
    {
        $this->status = static::STATUS_CLOSED;
        return $this->save();
    }
}
