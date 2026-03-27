<?php

namespace App\Models\Workshop\MasterData;

use App\Models\Workshop\ToolHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tools extends Model
{

    use SoftDeletes;
    const PAGE_LIMIT = 20;
    protected $table = 'tools';

    protected $fillable = [
        'code',
        'name',
        'qty',
        'location',
        'tool_category_id',
        'picture',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ToolCategory::class, 'tool_category_id', 'id');
    }

    public function getHistory($start, $end)
    {
        $histories =  ToolHistory::where('tools_id', $this->id)->when($start, function($q) use($start) {
                return $q->whereDate('created_at','>=', $start);
            } )->when($end, function($q) use($end) {
                $q->whereDate('created_at','<=', $end);
            } )->orderBy('id', 'desc');
        return $histories;
    }

    public function toolHistory()
    {
        return $this->morphMany(ToolHistory::class, 'toolHistory', 'type', 'type_id');
    }

    public function increaseStock(Model $reference, int $qty = 0)
    {
        $originalStock = $this->qty;

        $this->qty = $this->qty + $qty;
        $this->save();

        ToolHistory::capture($reference, $this, $originalStock);
    }

    public function decreaseStock(Model $reference, int $qty = 0, $decrease = true)
    {
        $originalStock = $this->qty;
        if ($decrease) {
            $this->qty = $this->qty - $qty;
            $this->save();
        }

        ToolHistory::capture($reference, $this, $originalStock);
    }
}
