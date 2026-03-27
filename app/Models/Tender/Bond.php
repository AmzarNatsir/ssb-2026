<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bond extends Model
{
    protected $table = "bond";    
    protected $fillable = [
        'project_id',
        'user_id',
        'bank_name',
        'letter_no',
        'bond_number',
        'bond_date',
        'bond_start_date',
        'bond_end_date',
        'bond_amount'
    ];

    // public function getBondDateAttribute($value)
    // {        
    //     return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    // }

    public function getFormattedBondAmountAttribute()
    {
        return number_format($this->bond_amount, 2, ',', '.');
    }

    // public function getBondStartDateAttribute($value)
    // {        
    //     return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    // }

    // public function getBondEndDateAttribute($value)
    // {        
    //     return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    // }

    // public function getCreatedAtAttribute($value)
    // {        
    //     return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    // }
    
    public function project()
    {
    	return $this->belongsTo(Project::class, 'project_id');
    }
}
