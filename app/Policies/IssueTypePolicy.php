<?php

namespace App\Policies;

use App\Models\User;
use App\Models\IssueType;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssueTypePolicy
{
    use HandlesAuthorization;

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
        //
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
        //
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
