<?php

namespace App\Models\auth;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Permission;

class RoleModel extends Model
{
    protected $fillable = ['name', 'guard_name'];

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }
}
