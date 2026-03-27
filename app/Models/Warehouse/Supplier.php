<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = ['name', 'address', 'phone', 'fax', 'contact_person', 'email', 'npwp', 'active', 'bank_name', 'bank_number'];

    public $timestamps = false;

    protected $attributes = [
        'active' => false,
    ];

    public function active()
    {
        return $this->where('active', true);
    }
}
