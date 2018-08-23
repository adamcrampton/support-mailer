<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(User $user)
    {
        $this->registerPolicies();

        Gate::define('admin-check', function($user) {
            $requiredAdminRoles = ['admin'];

            return in_array($user->permission->permission_name, $requiredAdminRoles);
        });

        Gate::define('editor-check', function($user) {
            $requiredEditorRoles = ['admin', 'editor'];

            return in_array($user->permission->permission_name, $requiredEditorRoles);
        });

        Gate::define('viewer-check', function($user) {
            $requiredViewerRoles = ['admin', 'editor', 'viewer'];

            return in_array($user->permission->permission_name, $requiredViewerRoles);
        });
    }
}
