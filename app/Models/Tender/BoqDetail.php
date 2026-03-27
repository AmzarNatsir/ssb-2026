<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class BoqDetail extends Model
{
    protected $table = "boq_detail";
    protected $fillable = [
        'boq_id',
        'equipment_category_id',
        'desc',
        'qty',
        'target',
        'price',
        'cost'
    ];

    protected $appends = ['formattedTarget','formattedPrice','formattedCost'];//'formattedTarget',

 //    public function getCostAttribute()
 //    {
	//     return ($this->qty * $this->price);        
	// }

    public function getFormattedTargetAttribute()
    {
        return number_format($this->target, 2, ',', '.');
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, ',', '.');
    }

    public function getFormattedCostAttribute()
    {
        return number_format($this->cost, 2, ',', '.');
    }

	public function bog()
	{
		return $this->belongsTo(Boq::class, 'boq_id');
	}

    public function equipment()
    {
        return $this->belongsTo('App\Models\Workshop\EquipmentCategory','equipment_category_id');
    }
}
