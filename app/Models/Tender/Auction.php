<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Auction extends Model
{
    protected $table = "auction";    
    protected $fillable = [
        'project_id',
        'user_id',
        'sender_id',
        'phase_number',
        'send_date',
        'accepted_date',
        'accepted_document_number'
    ];

    protected $dates = ['formattedSendDate'];

    public function getFormattedSendDateAttribute()
    {        
        return Carbon::parse($this->send_date)->isoFormat('DD/MM/YYYY');
    }

    public function getFormattedAcceptedDateAttribute()
    {        
        return Carbon::parse($this->accepted_date)->isoFormat('DD/MM/YYYY');
    }    

    public function project()
    {
    	return $this->belongsTo(Project::class, 'project_id');
    }

    public function filetypes()
    {
        return $this->belongsToMany('App\Models\Tender\FileTypes','auction_file')->withPivot('file_types_id','created_at', 'updated_at');
    }

    public function scopeWithPhaseNumber($query, $phaseNumber)
    {
    	$query->where('phase_number', $phaseNumber);
    }
}
