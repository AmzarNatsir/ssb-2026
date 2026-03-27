<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    protected $table = "projects";
    protected $fillable = [
        'number',
        'name',
        'desc',
        'source',
        'start_date',
        'end_date',
        'status_id',
        'value',
        'customer_id',
        'category_id',
        'is_tender',
        'target_tender_id',
        'location',
        'duration_in_month',
        'tipe_id',
        'jenis_project_id',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['date'];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('DD/MM/YYYY');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function status(){
        return $this->belongsTo(OpsiStatusProject::class, 'status_id');
    }

    public function category(){
        return $this->belongsTo(OpsiKategoriProject::class, 'category_id');
    }

    public function type(){
        return $this->belongsTo(OpsiTipeProject::class, 'tipe_id');
    }

    public function jenis(){
        return $this->belongsTo(OpsiJenisProject::class, 'jenis_project_id');
    }

    public function files()
    {
        return $this->belongsToMany('App\Models\Tender\Files','project_file')
            ->withPivot('created_at', 'updated_at');
    }

    public function survey(){
        // return $this->hasOne(Survey::class, 'id');
        return $this->hasOne(Survey::class, 'project_id');
    }

    public function approval(){
        // return $this->hasMany(ProjectApproval::class, 'id');
        return $this->hasMany(ProjectApproval::class, 'project_id');
    }

    public function preAnalystApproval(){
        return $this->hasOne(PreAnalystApproval::class, 'project_id');
    }

    // local scopes
    public function scopeIsSurveyAssigned($query){
        $excludedId = array();
        $projects = Project::whereHas('survey')->get();
        foreach ($projects as $project) {
            if(!$project){
                array_push($excludedId, $project->id);
            }
        }
        return $query->whereNotIn('id', $excludedId);
    }

    public function scopeWithProjectManagerApproval($query, $projectId, $idJabatan)
    {
        $query->addSelect([
            'pm_approval' =>
                ProjectApproval::selectRaw('project_approval.hasil')
                ->join('hrd_karyawan as kar', function ($join){
                    $join->on('project_approval.user_id', '=', 'kar.id');
                })
                // })
                // ->join('users as pm_user', function($join){
                //     $join->on('project_approval.user_id', '=', 'pm_user.id');
                // })
                // ->join('hrd_karyawan as kar', function ($join){
                //     $join->on('pm_user.nik', '=', 'kar.nik');
                // })
            ->whereColumn('project_approval.project_id', '=', $projectId)
            ->where('kar.id_jabatan', $idJabatan)
            ->take(1)
            ->orderBy('project_approval.id')
        ]);
    }

    public function scopeWithOpsManagerApproval($query, $projectId, $idJabatan)
    {
        $query->addSelect([
            'manops_approval' =>
                ProjectApproval::selectRaw('project_approval.hasil')
                ->join('hrd_karyawan as kar', function ($join){
                    $join->on('project_approval.user_id', '=', 'kar.id');
                })
                // ->join('users as pm_user', function($join){
                //     $join->on('project_approval.user_id', '=', 'pm_user.id');
                // })
                // ->join('hrd_karyawan as kar', function ($join){
                //     $join->on('pm_user.nik', '=', 'kar.nik');
                // })
            ->whereColumn('project_approval.project_id', '=', $projectId)
            ->where('kar.id_jabatan', $idJabatan)
            ->take(1)
            ->orderBy('project_approval.id')
        ]);
    }

    public function scopeWithDirectorApproval($query, $projectId, $idJabatan)
    {
        $query->addSelect([
            'direktur_approval' =>
                ProjectApproval::selectRaw('project_approval.hasil')
                ->join('hrd_karyawan as kar', function ($join){
                    $join->on('project_approval.user_id', '=', 'kar.id');
                })
                // ->join('users as pm_user', function($join){
                //     $join->on('project_approval.user_id', '=', 'pm_user.id');
                // })
                // ->join('hrd_karyawan as kar', function ($join){
                //     $join->on('pm_user.nik', '=', 'kar.nik');
                // })
            ->whereColumn('project_approval.project_id', '=', $projectId)
            ->where('kar.id_jabatan', $idJabatan)
            ->take(1)
            ->orderBy('project_approval.id')
        ]);
    }

    public function scopeWithDoesntHaveApproval($query)
    {
        $query->leftJoin('pre_analyst_approval as preanalyst', 'preanalyst.project_id', 'projects.id')
            ->whereNull('preanalyst.is_approve')
            ->addSelect('is_approve');
    }

    public function scopeWithHasApproval($query)
    {
        $query->leftJoin('pre_analyst_approval as preanalyst', 'preanalyst.project_id', 'projects.id')
            ->whereNotNull('preanalyst.is_approve')
            ->addSelect('is_approve');
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 4);
    }

    public function boq(){
        return $this->hasOne(Boq::class, 'project_id');
        // return $this->hasMany(Boq::class, 'project_id');
    }

    public function bond()
    {
        return $this->hasOne(Bond::class, 'project_id');
    }

    public function auction()
    {
        return $this->hasMany(Auction::class, 'project_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'project_id');
    }

    public function workAssignment()
    {
        return $this->hasOne(WorkAssignment::class, 'project_id');
    }
}
