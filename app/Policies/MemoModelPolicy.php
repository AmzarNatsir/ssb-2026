<?php

namespace App\Policies;

use App\Models\HRD\MemoModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemoModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HRD\MemoModel  $memo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MemoModel $memo)
    {
        // Allow if memo is active
        return (int)$memo->status === 1;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\MemoModel  $memoModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MemoModel $memoModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\MemoModel  $memoModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MemoModel $memoModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\MemoModel  $memoModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MemoModel $memoModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\MemoModel  $memoModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MemoModel $memoModel)
    {
        //
    }
}
