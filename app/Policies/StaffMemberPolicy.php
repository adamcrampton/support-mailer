<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StaffMember;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class StaffMemberPolicy
{
    use HandlesAuthorization;

    private $defaultPermissionLevels = ['admin', 'editor'];

    /**
     * Determine whether the user can view the index page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can view the staff member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function view(User $user, StaffMember $staffMember)
    {
        //
    }

    /**
     * Determine whether the user can create staff members.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can update the staff member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function update(User $user, StaffMember $staffMember)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can delete the staff member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function delete(User $user, StaffMember $staffMember)
    {
        //
    }

    /**
     * Determine whether the user can restore the staff member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function restore(User $user, StaffMember $staffMember)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the staff member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StaffMember  $staffMember
     * @return mixed
     */
    public function forceDelete(User $user, StaffMember $staffMember)
    {
        //
    }
}
