<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{    
    protected $table = "customers";
    protected $fillable = [
        'id',
        'number',
        'company_name',
        'company_address',
        'contact_person_name',
        'contact_person_number'
    ];
}