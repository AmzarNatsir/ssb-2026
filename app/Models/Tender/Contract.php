<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contract extends Model
{
    protected $table = "contract";
    protected $fillable = [
        'project_id',
        'user_id',
        'contract_no',
        'contract_date',
        'auction_pass_letter_no',
        'auction_pass_letter_date',
        'accepted_document_number',
        'kickoff_meeting_date',
        'kickoff_meeting_note'
    ];

    public function project()
    {
    	return $this->belongsTo(Project::class, 'project_id');
    }

    public function getContractDateAttribute($value)
    {        
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getKickOffMeetingDateAttribute($value)
    {        
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getCreatedAtAttribute($value)
    {        
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }
}
