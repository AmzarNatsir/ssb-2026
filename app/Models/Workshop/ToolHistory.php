<?php

namespace App\Models\Workshop;

use App\Models\Workshop\MasterData\Tools;
use Illuminate\Database\Eloquent\Model;

class ToolHistory extends Model
{
  protected $table ='tool_history';
  protected $fillable = [
    'user_id', 'type', 'type_id', 'tools_id', 'current_stock', 'updated_stock'
  ];

  public function tools()
  {
    return $this->belongsTo(Tools::class, 'tools_id', 'id');
  }

  public function toolHistory()
  {
    return $this->morphTo('toolHistory', 'type', 'type_id');
  }

  public static function capture(Model $type, Tools $tools,$currentStock = 0)
  {
    $toolHistory = new static();
    $toolHistory->user_id = auth()->id();
    $toolHistory->tools_id = $tools->id;
    $toolHistory->current_stock = $currentStock;
    $toolHistory->updated_stock = $tools->qty;

    $type->toolHistory()->save($toolHistory);
  }

  public function getDescriptionAttribute()
  {
    // dd(ToolUsage::class);
    if ($this->type == ToolUsage::class) {
      return 'Tool Usage : '.$this->toolHistory?->number;
      // return "<a target='_blank' href='".route('warehouse.issued.print', $this->reference_id)."'>".$this->referenceObject->number."(Issued)</a>";
    }

    if ($this->type == Tools::class) {
      return 'Master Data Tools';
    }

    if ($this->type == ToolsReceiving::class) {
      return 'Tool Receiving :'.$this->toolHistory?->number;
    }

    if ($this->type == ToolMissing::class) {
      return 'Tool Missing From Tool Usage : '.$this->toolHistory->tool_usage?->number;
    }


  }

  public function getInOutAttribute()
  {
    $method = '';
    $missing = 0;

    if ($this->current_stock < $this->updated_stock ) {
      $method = 'increase';
    } else {
      $method = 'decrease';
    }

    if ($this->type == ToolMissing::class) {
      $method = 'missing';
      $missing = ToolMissing::where('id', $this->type_id)->with('details')->get()->map(function($item){
        return $item->details->where('tools_id', $this->tools_id)->sum('qty');

      })->sum();
    }

    return '<td>'.($method == 'increase' ? $this->updated_stock - $this->current_stock : 0 ).'</td><td>'.($method == 'decrease' ? $this->current_stock - $this->updated_stock : 0 ).'</td><td>'.$missing.'</td>';

  }
}
