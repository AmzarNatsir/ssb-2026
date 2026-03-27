<?php

namespace App\Models\Workshop;

use App\Models\Workshop\MasterData\Tools;
use Illuminate\Database\Eloquent\Model;

class ToolsReceivingItems extends Model
{
    protected $table = 'tools_receiving_items';
    protected $fillable = ['tool_receiving_id','tools_id','qty','description'];
    public $timestamps = false;

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'tools_id', 'id');
    }
}
