<?php

namespace App\Policies;

use App\Models\User;
use App\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ProviderPolicy
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
     * Determine whether the user can view the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Provider  $provider
     * @return mixed
     */
    public function view(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Provider  $provider
     * @return mixed
     */
    public function update(User $user, Provider $provider)
    {
        return in_array(Auth::user()->permission->permission_name, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Provider  $provider
     * @return mixed
     */
    public function delete(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Provider  $provider
     * @return mixed
     */
    public function restore(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Provider  $provider
     * @return mixed
     */
    public function forceDelete(User $user, Provider $provider)
    {
        //
    }
}
