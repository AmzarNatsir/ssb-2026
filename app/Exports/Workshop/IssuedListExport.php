<?php

namespace App\Exports\Workshop;

use App\Repository\Warehouse\Issued;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IssuedListExport implements FromCollection, WithMapping, WithHeadings
{
  public $options;
  private $rowNum = 0;

  public function __construct($options){
    $this->options = $options;
  }

  public function collection()
  {
    $keyword = $this->options->has('keyword') ? $this->options->keyword : null;
    $date_start = $this->options->has('date_start') ? $this->options->date_start : null;
    $date_end = $this->options->has('date_end') ? $this->options->date_end : null;

    return (new Issued())->list(
      array_merge($this->options->all(),[
          'with' => ['received_by_user', 'created_user.karyawan', 'work_order.equipment'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where_like' => ['remarks' => $keyword, 'work_order.number' => $keyword],
        ]
      ));
  }

  public function map($issued) : array {
    return [
      ++$this->rowNum,
      $issued->number,
      $issued->dateCreation,
      $issued->reference_id ? $issued->work_order->number : '',
      $issued->getFormattedDate('received_at'),
      $issued->received_by_user->nm_lengkap ?? '',
      $issued->created_user->karyawan->nm_lengkap ?? '',
      $issued->remarks
    ];
  }

  public function headings(): array
  {
    return [
      '#',
      'No. Issued',
      'Tanggal Pembuatan',
      'Keb/Unit',
      'Tanggal Terima',
      'Diterima Oleh',
      'Dibuat Oleh',
      'Keterangan'
    ];
  }
}
