<?php

namespace App\Policies;

use App\Models\Tender\Survey;
use App\Models\Tender\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    // public function viewAny(User $user)
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $survey
     * @return mixed
     */
    // public function view(User $user, Survey $survey)
    // {
    //     // return true;
    // }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    // public function create(User $user)
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $survey
     * @return mixed
     */
    public function update(User $user, Survey $survey)
    {           
        // only assigned surveyor and project doesn't have preanalyst
        // return ($user->id === $survey->surveyor_id && is_null($survey->project->preAnalystApproval)); 
        $surveyor_group = explode(",", $survey->surveyor_group);
        return (in_array($user->id, $surveyor_group)); 
    }    

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $survey
     * @return mixed
     */
    // public function delete(User $user, Survey $survey)
    // {
    //     //
    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $survey
     * @return mixed
     */
    // public function restore(User $user, Survey $survey)
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $survey
     * @return mixed
     */
    // public function forceDelete(User $user, Survey $survey)
    // {
    //     //
    // }
}
