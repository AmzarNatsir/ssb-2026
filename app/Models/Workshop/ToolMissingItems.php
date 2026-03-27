<?php

namespace App\Models\Workshop;

use App\Models\Workshop\MasterData\Tools;
use Illuminate\Database\Eloquent\Model;

class ToolMissingItems extends Model
{
    protected $table = 'tool_missing_items';
    protected $fillable = ['tool_missing_id', 'tools_id', 'qty'];
    public $timestamps = false;

    public function tool_mising()
    {
        return $this->belongsTo(ToolMissing::class, 'tool_missing_id', 'id');
    }

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'tools_id', 'id');
    }
    
}
