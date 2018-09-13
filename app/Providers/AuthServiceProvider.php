<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ConfigPolicy;
use App\Policies\IssueTypePolicy;
use App\Policies\ProviderPolicy;
use App\Policies\StaffMemberPolicy;
use App\Policies\SubmissionLogPolicy;
use App\Policies\UserPolicy;
use App\Models\IssueType;
use App\Models\Provider;
use App\Models\StaffMember;
use App\Models\SubmissionLog;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Config::class => ConfigPolicy::class,
        IssueType::class => IssueTypePolicy::class,
        Provider::class => ProviderPolicy::class,
        StaffMember::class => StaffMemberPolicy::class,
        SubmissionLog::class => SubmissionLogPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(User $user)
    {
        $this->registerPolicies();

        // Gates if you need them.
        Gate::define('admin-functions', function($user) {
            $requiredAdminRoles = ['admin'];

            return in_array($user->permission->permission_name, $requiredAdminRoles);
        });

        Gate::define('editor-functions', function($user) {
            $requiredEditorRoles = ['admin', 'editor'];

            return in_array($user->permission->permission_name, $requiredEditorRoles);
        });

        Gate::define('viewer-functions', function($user) {
            $requiredViewerRoles = ['admin', 'editor', 'viewer'];

            return in_array($user->permission->permission_name, $requiredViewerRoles);
        });
    }
}
