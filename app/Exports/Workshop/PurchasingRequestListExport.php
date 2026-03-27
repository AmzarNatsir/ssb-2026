<?php

namespace App\Exports\Workshop;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Repository\Warehouse\PurchasingRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchasingRequestListExport implements FromCollection, WithMapping, WithHeadings
{
  public $options;
  private $rowNum = 0;

  public function __construct($options){
    $this->options = $options;
  }

  public function collection()
  {
    $request_type = $this->options->has('request_type') ? $this->options->request_type : null;
    $date_start = $this->options->has('date_start') ? $this->options->date_start : null;
    $date_end = $this->options->has('date_end') ? $this->options->date_end : null;

    return (new PurchasingRequest())->list(
      array_merge($this->options->all(),[
          'with' => ['details', 'work_order.work_request.part_order'],
          'date_range' => [$date_start, $date_end, 'created_at'],
          'where' => ["purchasing_type" => $request_type]
        ]
      ));
  }

  public function map($purchasing_request) : array {
    return [
      ++$this->rowNum,
      $purchasing_request->number,
      $purchasing_request->dateCreation,
      $purchasing_request->type,
      $purchasing_request->reference_id ? $purchasing_request->work_order->number : '',
      $purchasing_request->total_qty,
      warehouse_number_format($purchasing_request->total_price)
    ];
  }

  public function headings(): array
  {
    return [
      '#',
      'No. Purchasing Request',
      'Tanggal Pembuatan',
      'Tipe Permintaan',
      'Keb/Unit',
      'Total Qty',
      'Total Estimasi Harga'
    ];
  }

}

