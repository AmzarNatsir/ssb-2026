<?php

namespace App\Exports;

use App\Models\Workshop\WorkOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorkOrderExport implements FromQuery, WithMapping, WithHeadings
{
    public $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function query()
    {
        return WorkOrder::with(['equipment', 'work_request', 'additional_attributes', 'project', 'driver'])->search($this->options);
    }

    public function map($workOrder): array
    {
        return [
            $workOrder->number,
            $workOrder->work_request->number,
            date('Y-m-d', strtotime($workOrder->created_at)),
            $workOrder->equipment->name,
            $workOrder->project->name,
            $workOrder->location->location_name,
            $workOrder->driver->nm_lengkap,
            $workOrder->work_request->activity,
            ($workOrder->status == WorkOrder::STATUS_OPEN ? 'OPEN' : 'CLOSED'),
            workshop_datetime($workOrder->date_start),
            workshop_datetime($workOrder->date_finish)
        ];
    }

    public function headings(): array
    {
        return [
            'Number',
            'Work Request Number',
            'Created At',
            'Unit',
            'Project',
            'Location',
            'Operator/Driver',
            'Activity',
            'Status',
            'Date/Time Start',
            'Date/Time Finish',
        ];
    }
}
