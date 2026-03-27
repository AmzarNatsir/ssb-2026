<?php

namespace App\Models\Warehouse;

use App\User;
use Illuminate\Database\Eloquent\Model;

class StockChanges extends Model
{
  protected $table = 'stock_changes';
  protected $fillable = [
    'spare_part_id',
    'module',
    'reference',
    'reference_id',
    'method',
    'stock',
    'updated_stock',
    'user_id'
  ];

  const DEDUCT = 'deduct';
  const INCREASE = 'increase';
  const CREATED = 'created';


  public function save(array $options = [])
  {
    if (!$this->user_id) {
      $this->user_id = auth()->user()->id;
    }

    return parent::save($options);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function captureChanges(\App\Models\Warehouse\SparePart $sparePart, $method = '')
  {

  }

  public function getReferenceObjectAttribute()
  {
    return $reference = $this->reference::find($this->reference_id);
  }

  public function getDescriptionAttribute()
  {

    if (str_contains(strtolower($this->module),'receiving')) {
      if (str_contains(strtolower($this->module),'destroy')){
        return "Delete Receiving Number ".Receiving::withTrashed()?->find($this->reference_id)?->number;
      } else {
        if ($this->method == static::DEDUCT) {
          return "<a target='_blank' href='".route('warehouse.issued.print', $this->reference_id)."'>".$this->referenceObject?->number."(Issued)</a>";
        }
        return "<a target='_blank' href='".route('warehouse.receiving.print', $this->reference_id)."'>".$this->referenceObject?->number."(Receiving)</a>";
      }
    } elseif (str_contains(strtolower($this->module),'issued')) {
      if (str_contains(strtolower($this->module),'destroy')){
        return 'Delete Issued Number '.Issued::withTrashed()?->find($this->reference_id)?->number;
      }
      return "<a target='_blank' href='".route('warehouse.issued.print', $this->reference_id)."'>".$this->referenceObject?->number." (Issued)</a>";
    } else {
      return 'Master Data Sparepart';
    }
  }

}
