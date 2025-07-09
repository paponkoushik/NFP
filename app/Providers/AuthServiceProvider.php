<?php

namespace App\Providers;

use App\Enums\UserRoles;
use App\Policies\LegalSupportPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(UserRoles::SuperAdmin->value, [RolePolicy::class, 'isSuperAdmin']);
        Gate::define(UserRoles::NfpAdmin->value, [RolePolicy::class, 'isNFPAdmin']);
        Gate::define(UserRoles::OrgAdmin->value, [RolePolicy::class, 'isOrgAdmin']);
        Gate::define(UserRoles::LegalAdmin->value, [RolePolicy::class, 'isLegalAdmin']);
        Gate::define(UserRoles::Lawyer->value, [RolePolicy::class, 'isLawyer']);
        Gate::define(UserRoles::ClientAdmin->value, [RolePolicy::class, 'isClientAdmin']);
        Gate::define(UserRoles::Individual->value, [RolePolicy::class, 'isIndividual']);

        Gate::define('user', [RolePolicy::class, 'isUser']);
        Gate::define('admins', [RolePolicy::class, 'isAdmins']);
        Gate::define('hasRole', [RolePolicy::class, 'hasAccess']);

        Gate::define('visible', function ($user, $roles) {
            $roles = str_replace('|', ',', removeSpace($roles));

            if ($roles === '*') {
                return true;
            }

            return $user->hasRole(explode(',', $roles));
        });

        // Legal Support Gate
        Gate::define('post-legal-support', [LegalSupportPolicy::class, 'postSupport']);
        Gate::define('org-legal-support', [LegalSupportPolicy::class, 'orgSupport']);
    }
}
