<?php

namespace App\Models\Workshop;

use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Uop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scrap extends Model
{
    use SoftDeletes;

    protected $table = 'scrap';
    protected $fillable = [
        'source_type', 'source_id', 'name', 'number', 'brand_id', 'uop_id', 'qty', 'weight','user_id'
    ];

    public function save(array $options = [])
    {
        if (auth()->user()) {
            if (!$this->user_id) {
                $this->user_id = auth()->user()->id;
            }
        }

        return parent::save($options);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function uop()
    {
        return $this->belongsTo(Uop::class, 'uop_id', 'id');
    }

    public function scrapable()
    {
        return $this->morphTo('scrapable', 'source_type', 'source_id');
    }

}
