<?php

namespace App\Repository\Workshop\Traits;

use App\Models\HRD\KaryawanModel;
use App\Models\Tender\Project;
use App\Models\Workshop\Location;
use App\Models\Workshop\MasterData\Tools;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WorkshopTrait
{
    protected $filter_type_equipment = 'equipment';
    protected $filter_type_location = 'location';
    protected $filter_type_project = 'project';

    public function numbering($number)
    {
        switch ($number) {
            case $number < 10:
                return '0000' . $number;
                break;
            case $number < 100:
                return '000' . $number;
                break;
            case $number < 1000:
                return '00' . $number;
                break;
            case $number < 10000:
                return '0' . $number;
                break;
            default:
                return $number;
                break;
        }
    }

    public function getNumberPrefix()
    {
        return static::NUMBER_PREFIX;
    }

    public function generateNumber(): string
    {
        $lastNumber = $this->getLastNumber() + 1;

        return $this->extractPrefix() . $this->numbering($lastNumber);
    }

    public function getLastNumber(): int
    {
        $lastNumber =  $this->selectRaw("CAST(SUBSTR(number,-5,5) as UNSIGNED) AS latest_number")
            ->whereRaw("number like '" . $this->extractPrefix() . "%'")
            ->orderByRaw('CAST(SUBSTR(number,-5,5) as UNSIGNED) DESC')
            ->limit(1)
            ->get('latest_number');

        return $lastNumber->count() ? $lastNumber->first()->latest_number : 0;
    }

    public function extractPrefix()
    {
        $prefix = $this->getNumberPrefix();

        $prefix = preg_replace('/{year}/', date('Y'), $prefix);
        $prefix = preg_replace('/{month}/', date('m'), $prefix);

        return $prefix;
    }

    public function editable()
    {
        return (strtotime(now()) - strtotime($this->created_at)) < 86400;
    }

    public function increaseToolsStock()
    {
        $this->refresh();
        $details = $this->details;

        foreach ($details as $key => $value) {

            $value->tools->increaseStock($this, $value->qty);
        }
    }

    public function decreaseToolsStock($decrease = true)
    {
        $this->refresh();
        $details = $this->details;

        foreach ($details as $key => $value) {
            $value->tools->decreaseStock($this, $value->qty, $decrease);
        }
    }

    public function scopeSearch($q, $options)
    {
        $type = $options->type ?? null;
        $value = $options->keyword ?? null;

        if ($type && $value) {
            if ($type == $this->filter_type_equipment) {
                return $q->whereHas('equipment', function ($q) use ($value) {
                    return $q->where('name', 'like', '%' . $value . '%')->orWhere('code', 'like', '%' . $value . '%');
                });
            }

            if ($type == $this->filter_type_location) {
                return $q->whereHas('location', function ($q) use ($value) {
                    return $q->where('location_name', 'like', '%' . $value . '%');
                });
            }

            if ($type == $this->filter_type_project) {
                return $q->whereHas('project', function ($q) use ($value) {
                    return $q->where('name', 'like', '%' . $value . '%');
                });
            }
        }

        if ($options->get('start') && $options->get('end')) {
            $start = date('Y-m-d', strtotime($options['start']));
            $end = date('Y-m-d', strtotime($options['end']));

            if ($this instanceof \App\Models\Workshop\WorkRequest || $this instanceof \App\Models\Workshop\WorkOrder) {
                return $q->whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end);
            } else {
                $q->whereDate('date', '>=', $start)
                    ->whereDate('date', '<=', $end);
            }
        }
    }

    public function driver()
    {
        return $this->belongsTo(KaryawanModel::class, 'driver_id', 'id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
