<?php

namespace App\Policies;

use App\Models\User;
use App\Config;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the index page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
        return Auth::user()->permission->permission_name === 'admin';
    }

    /**
     * Determine whether the user can view the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Config  $config
     * @return mixed
     */
    public function view(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can create configs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Config  $config
     * @return mixed
     */
    public function update(User $user, Config $config)
    {
        return Auth::user()->permission->permission_name === 'admin';
    }

    /**
     * Determine whether the user can delete the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Config  $config
     * @return mixed
     */
    public function delete(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can restore the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Config  $config
     * @return mixed
     */
    public function restore(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Config  $config
     * @return mixed
     */
    public function forceDelete(User $user, Config $config)
    {
        //
    }
}
