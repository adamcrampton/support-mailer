<?php

namespace App\Policies;

use App\Models\User;
use App\SubmissionLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the submission log.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SubmissionLog  $submissionLog
     * @return mixed
     */
    public function view(User $user, SubmissionLog $submissionLog)
    {
        //
    }

    /**
     * Determine whether the user can create submission logs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the submission log.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SubmissionLog  $submissionLog
     * @return mixed
     */
    public function update(User $user, SubmissionLog $submissionLog)
    {
        //
    }

    /**
     * Determine whether the user can delete the submission log.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SubmissionLog  $submissionLog
     * @return mixed
     */
    public function delete(User $user, SubmissionLog $submissionLog)
    {
        //
    }

    /**
     * Determine whether the user can restore the submission log.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SubmissionLog  $submissionLog
     * @return mixed
     */
    public function restore(User $user, SubmissionLog $submissionLog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the submission log.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SubmissionLog  $submissionLog
     * @return mixed
     */
    public function forceDelete(User $user, SubmissionLog $submissionLog)
    {
        //
    }
}
