<?php

namespace App\Policies;

use App\Models\HRD\KaryawanModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KaryawanModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Allow if user has HRD related roles or is a Super Admin
        return $user->hasAnyRole(['HRD', 'Manager HRD', 'Super Admin', 'super_admin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\HRD\KaryawanModel  $karyawan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, KaryawanModel $karyawan)
    {
        // Allow if user is viewing their own profile (linked by NIK)
        if ($user->nik === $karyawan->nik) {
            return true;
        }

        // Allow if user has HRD related roles or is a Super Admin
        return $user->hasAnyRole(['HRD', 'Manager HRD', 'Super Admin', 'super_admin']);
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
     * @param  \App\Models\Models\HRD\KaryawanModel  $karyawanModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, KaryawanModel $karyawanModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\KaryawanModel  $karyawanModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, KaryawanModel $karyawanModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\KaryawanModel  $karyawanModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, KaryawanModel $karyawanModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Models\HRD\KaryawanModel  $karyawanModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, KaryawanModel $karyawanModel)
    {
        //
    }
}
