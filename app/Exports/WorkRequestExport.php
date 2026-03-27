<?php

namespace App\Exports;

use App\Models\Workshop\WorkRequest;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorkRequestExport implements FromQuery, WithHeadings, WithMapping
{
    public $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function query()
    {
        return WorkRequest::with(['equipment', 'location', 'additional_attributes', 'schedule', 'approved'])->search($this->options);
    }

    public function map($workRequest): array
    {
        return [
            $workRequest->number,
            date('Y-m-d', strtotime($workRequest->created_at)),
            $workRequest->equipment->name,
            $workRequest->location->location_name,
            $workRequest->activity,
            $workRequest->priority,
            WorkRequest::STATUS[$workRequest->status],
            $workRequest->description,
            optional($workRequest->approved)->karyawan?->nm_lengkap,
            ($workRequest->approved_at ? date('Y-m-d', strtotime($workRequest->approved_at)) : ''),
            ($workRequest->schedule ? date('Y-m-d', strtotime($workRequest->schedule->date)) : ''),
        ];
    }

    public function headings(): array
    {
        return [
            'Number',
            'Created At',
            'Unit',
            'Location',
            'Activity',
            'Priority',
            'Status',
            'Description',
            'Approved By',
            'Approved At',
            'Scheduled At',
        ];
    }
}
