<?php

namespace App\Models\Warehouse;

use App\Repository\Warehouse\StockChanges;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePart extends Model
{
    use SoftDeletes;
    const PAGE_LIMIT = 20;

    protected $table = 'spare_part';

    protected $fillable = [
        'part_number',
        'interchange',
        'part_name',
        'brand_id',
        'uop_id',
        'category_id',
        'price',
        'rack',
        'location',
        'used_for',
        'min_stock',
        'max_stock',
        'stock',
        'weight',
        'is_geniune',
        'user_id'
    ];
    

    public function save(array $options = [])
    {
        if (!$this->user_id) {
            $this->user_id = auth()->user()->id;
        }

        return parent::save($options);
    }

    public function uop()
    {
        return $this->belongsTo(\App\Models\Warehouse\Uop::class, 'uop_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(\App\Models\Warehouse\Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Warehouse\Category::class, 'category_id', 'id');
    }

    public function stockChanges(){
        return $this->hasMany(\App\Models\Warehouse\StockChanges::class, 'spare_part_id', 'id');
    }

    public function increaseStock($qty, $reference = null )
    {
        $originalStock = $this->stock;
        
        $this->stock = $this->stock + $qty;
        $this->save();

        StockChanges::captureChanges([
            'spare_part' => $this,
            'reference' => get_class($reference), 
            'method' =>  \App\Models\Warehouse\StockChanges::INCREASE, 
            'stock' => $originalStock, 
            'updated_stock' => $this->stock,
            'reference_id' => $reference->id
        ]);
    }

    public function decreaseStock($qty, $reference = null)
    {
        $originalStock = $this->stock;

        $this->stock = $this->stock - $qty;
        $this->save();

        StockChanges::captureChanges([
            'spare_part' => $this,
            'reference' => get_class($reference), 
            'method' =>  \App\Models\Warehouse\StockChanges::DEDUCT, 
            'stock' => $originalStock, 
            'updated_stock' => $this->stock,
            'reference_id' => $reference->id
        ]);
    }
}
