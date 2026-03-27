<?php

namespace App\Exports;

use App\Models\Workshop\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InspectionExport implements FromQuery, WithHeadings, WithMapping
{
    public $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function query()
    {
        return Inspection::with(['equipment', 'driver'])->search($this->options);
    }

    public function map($inspection): array
    {
        $km_awal = $inspection->km_start;
        $km_akhir = $inspection->km_end;
        $hm_awal = $inspection->hm_start;
        $hm_akhir = $inspection->hm_end;
        $total_km = $km_akhir - $km_awal;
        $total_hm = $hm_akhir - $hm_awal;
        $ma = $total_hm > 0 ? $total_hm / ($total_hm + $inspection->breakdown_hour) * 100 : 0;
        $ua = $total_hm > 0 ? $total_hm / ($total_hm + $inspection->standby_hour) * 100 : 0;
        $pa = $total_hm > 0 ? ($total_hm + $inspection->standby_hour) / ($total_hm + $inspection->standby_hour + $inspection->breakdown_hour) * 100 : 0;
        $eu = $total_hm > 0 ? ($total_hm / ($total_hm + $inspection->standby_hour + $inspection->breakdown_hour) * 100) : 0;

        // dd($inspection, $total_km, $total_hm);

        return [
            date('Y-m-d', strtotime($inspection->date)),
            $inspection->equipment->name,
            $inspection->project->name,
            $inspection->driver->nm_lengkap,
            ($inspection->shift == 1 ? 'I' : 'II'),
            $inspection->km_start,
            $inspection->km_end,
            $total_km,
            $inspection->hm_start,
            $inspection->hm_end,
            $total_hm,
            $inspection->operating_hour,
            $inspection->standby_hour,
            $inspection->standby_description,
            $inspection->breakdown_hour,
            $inspection->breakdown_description,
            round($ma).'%',
            round($ua).'%',
            round($pa).'%',
            round($eu).'%'
        ];
    }

    public function headings(): array
    {
        return [
            'Date',
            'Unit',
            'Project',
            'Operator',
            'Shift',
            'KM Start',
            'KM End',
            'Total KM',
            'HM Start',
            'HM End',
            'Total HM',
            'Operating Hour',
            'Standby Hour',
            'Standby Description',
            'Breakdown Hour',
            'Breakdown Description',
            'MA',
            'UA',
            'PA',
            'EU'
        ];
    }
}
