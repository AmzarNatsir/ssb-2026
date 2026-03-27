<?php

namespace App\Models\Workshop;

use App\Models\Workshop\MasterData\Tools;
use Illuminate\Database\Eloquent\Model;

class ToolUsageItems extends Model
{
    const STATUS_OPEN = 0;
    const STATUS_CLOSED = 1;

    protected $table = 'tool_usage_items';
    protected $fillable = [
        'tool_usage_id', 'tools_id', 'qty', 'status', 'description'
    ];
    public $timestamps = false;

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'tools_id', 'id');
    }
}
