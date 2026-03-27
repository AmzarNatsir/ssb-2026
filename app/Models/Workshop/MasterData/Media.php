<?php

namespace App\Models\Workshop\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'workshop_media';
    protected $fillable = [
        'model',
        'model_id',
        'file',
    ];

    public function workshop_mediable()
    {
        return $this->morphTo();
    }

    public function delete()
    {
        if (Storage::delete(str_replace('storage', 'public', $this->file))) {
            return parent::delete();
        }
    }
}
