<?php

namespace App\Models\Warehouse;

use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\WorkOrder;
use App\Repository\Warehouse\Traits\WarehouseTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issued extends Model
{
    use SoftDeletes, WarehouseTrait;

    const PAGE_LIMIT = 20;

    const CURRENT_STATUS = 6;

    protected $table = 'issued';

    protected $fillable = [
        'number', 
        'reference_id',
        'remarks',
        'received_at',
        'received_by',
        'created_by'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(IssuedDetail::class, 'issued_id', 'id');
    }

    public function save(array $options = [])
    {
        if (!$this->created_by) {
            $this->created_by = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function received_by_user(): BelongsTo
    {
        return $this->belongsTo(KaryawanModel::class, 'received_by', 'id');
    }

    public function editable()
    {
        // issued is editable and deleteable befre 24 hours after created
        return (strtotime(now()) - strtotime($this->created_at)) < 86400  ;
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'reference_id', 'id');
    }


}
