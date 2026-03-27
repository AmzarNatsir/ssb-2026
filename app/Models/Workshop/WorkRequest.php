<?php

namespace App\Models\Workshop;

use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\MasterData\AdditionalAttributes;
use App\Models\Workshop\MasterData\Media;
use App\Models\Workshop\MasterData\Schedule;
use App\Models\Workshop\MasterData\WorkshopPartOrder;
use App\Repository\Workshop\Traits\WorkshopTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkRequest extends Model
{
    use SoftDeletes, WorkshopTrait;

    const STATUS_OPEN = 'OPEN';
    const STATUS_PENDING = 'PENDING';
    const STATUS_CLOSED = 'CLOSED';
    const STATUS_WO = 'WO';
    const PRIORITY_HIGH = 'HIGH';
    const PRIORITY_NORMAL = 'NORMAL';
    const PRIORITY_LOW = 'LOW';
    const ACTIVITY_SERVICE = 'SERVICE';
    const ACTIVITY_REPAIR = 'REPAIR';
    const PAGE_LIMIT = 50;

    const STATUS = [
        1 => self::STATUS_OPEN,
        2 => self::STATUS_PENDING,
        3 => self::STATUS_WO,
        4 => self::STATUS_CLOSED,
    ];

    const NUMBER_PREFIX = 'WR.{year}.{month}.';
    protected $table = 'work_request';
    protected $fillable = [
        'number',
        'equipment_id',
        'approved_by',
        'approved_at',
        'location_id',
        'project_id',
        'driver_id',
        'activity',
        'priority',
        'status',
        'description',
        'created_by',
        'updated_by',
    ];

    public function save(array $options = [])
    {
        $loggedInUser = auth()->user()->id;

        if (!$this->created_by) {
            $this->created_by = $loggedInUser;
        }

        if (!$this->number) {
            $this->number = $this->generateNumber();
        }

        $this->updated_by = $loggedInUser;

        return parent::save($options);
    }

    public function driver()
    {
        return $this->belongsTo(KaryawanModel::class, 'driver_id', 'id');
    }

    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function scopeFilter($query, $options)
    {
        $options = collect($options);

        if ($options->has('equipment_id') && $options['equipment_id']) {
            $query->where('equipment_id', $options['equipment_id']);
        }

        if ($options->get('start') && $options->get('end')) {
            $start = date('Y-m-d', strtotime($options['start']));
            $end = date('Y-m-d', strtotime($options['end']));
            $query->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }
        return $query;
    }

    public function scopeAlreadyApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function work_order()
    {
        return $this->hasOne(WorkOrder::class, 'work_request_id', 'id');
    }

    public function scopeNotInWorkOrder($query)
    {
        return $query->doesnthave('work_order');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function additional_attributes()
    {
        return $this->morphMany(AdditionalAttributes::class, 'additional_attributeable', 'reference_type', 'reference_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'workshop_mediable', 'model', 'model_id');
    }

    public function part_order()
    {
        return $this->morphMany(WorkshopPartOrder::class, 'partable', 'type', 'type_id');
    }

    public function schedule()
    {
        return $this->morphOne(Schedule::class, 'scheduleable', 'model', 'model_id');
    }

    public function getScheduleTitle()
    {
        return $this->number . ':' . $this->activity . ':' . $this->priority;
    }
}
