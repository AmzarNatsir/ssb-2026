<?php

namespace App\Models\Workshop;

use App\Models\Warehouse\Supplier;
use App\Repository\Workshop\Traits\WorkshopTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsReceiving extends Model
{
    use SoftDeletes, WorkshopTrait;

    const PAGE_LIMIT = 50;
    const NUMBER_PREFIX = 'TR.{year}.{month}.';
    protected $table = 'tools_receiving';
    protected $fillable = ['number', 'supplier_id', 'description','created_by', 'updated_by'];

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
        
        return parent::save($options);
    }

    public function details()
    {
        return $this->hasMany(ToolsReceivingItems::class, 'tools_receiving_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function toolHistory()
    {
        return $this->morphMany(ToolHistory::class, 'toolHistory', 'type', 'type_id');
    }
}
