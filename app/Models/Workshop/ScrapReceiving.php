<?php

namespace App\Models\Workshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScrapReceiving extends Model
{
    use SoftDeletes;

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    protected $table = 'scrap_receiving';
    protected $fillable = ['number', 'work_order_id', 'date', 'description', 'status', 'created_by', 'updated_by'];

    public function save(array $options = [])
    {
        if (auth()->user()) {
            $userId = auth()->user()->id;
            if (!$this->created_by) {
                $this->created_by = $userId;
            }

            $this->updated_by = $userId;
        }

        return parent::save($options);
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }
}
