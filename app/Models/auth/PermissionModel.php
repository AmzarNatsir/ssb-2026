<?php

namespace App\Models\auth;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $fillable = ['name', 'guard_name'];
}
