<?php

namespace App\Models\Workshop\MasterData;

use Illuminate\Database\Eloquent\Model;

class AdditionalAttributes extends Model
{
    protected $table = 'additional_attributes';

    protected $fillable = [
        'reference_id',
        'reference_type',
        'name',
        'value',
        'description'
    ];

    public $timestamps = false;

    // public function save(array $options = [])
    // {
    //     dd($options);
    // }

    public function additional_attributeable()
    {
        return $this->morphTo();
    }
}
