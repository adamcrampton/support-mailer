<?php

namespace App\Policies;

use App\Models\User;
use App\Models\IssueType;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class IssueTypePolicy
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
     * Determine whether the user can view the issue type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\IssueType  $issueType
     * @return mixed
     */
    public function view(User $user, IssueType $issueType)
    {
        //
    }

    /**
     * Determine whether the user can create issue types.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can update the issue type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\IssueType  $issueType
     * @return mixed
     */
    public function update(User $user, IssueType $issueType)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can delete the issue type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\IssueType  $issueType
     * @return mixed
     */
    public function delete(User $user, IssueType $issueType)
    {
        //
    }

    /**
     * Determine whether the user can restore the issue type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\IssueType  $issueType
     * @return mixed
     */
    public function restore(User $user, IssueType $issueType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the issue type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\IssueType  $issueType
     * @return mixed
     */
    public function forceDelete(User $user, IssueType $issueType)
    {
        //
    }
}
