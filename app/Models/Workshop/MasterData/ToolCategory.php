<?php

namespace App\Models\Workshop\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolCategory extends Model
{
    use SoftDeletes;

    protected $table = 'tool_category';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
