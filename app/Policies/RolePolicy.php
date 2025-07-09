<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Check logged in user is super admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isSuperAdmin(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Check logged in user is super admin or admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isAdmins(User $user)
    {
        return $user->isAdmins();
    }

    /**
     * Check logged in user is client admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isNFPAdmin(User $user)
    {
        return $user->isNfpAdmin();
    }

    /**
     * Check logged in user is client admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isClientAdmin(User $user)
    {
        return $user->isClientAdmin();
    }

    /**
     * Check logged in user is org admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isOrgAdmin(User $user)
    {
        return $user->isOrgAdmin();
    }

    /**
     * Check logged in user is legal admin.
     *
     * @param  User $user
     * @return bool
     */
    public function isLegalAdmin(User $user)
    {
        return $user->isLegalAdmin();
    }

    /**
     * Check logged in user is lawyer.
     *
     * @param  User $user
     * @return bool
     */
    public function isLawyer(User $user)
    {
        return $user->isLawyer();
    }

    /**
     * Check logged in user is Individual.
     *
     * @param  User $user
     * @return bool
     */
    public function isIndividual(User $user)
    {
        return $user->isIndividual();
    }

    /**
     * Check logged in user is user.
     *
     * @param  User $user
     * @return bool
     */
    public function isUser(User $user)
    {
        return $user->isUser();
    }

    /**
     * Check logged in user has access.
     *
     * @param  User $user
     * @return bool
     */
    public function hasAccess(User $user, $abilities)
    {
        return $user->isAdmins() || $this->hasPermissionToAccess($user, $abilities);
    }

    /**
     * Check has access permission.
     *
     * @param  User $user
     * @param  string $abilities
     * @return bool
     */
    protected function hasPermissionToAccess(User $user, $abilities)
    {
        $abilities = explode('|', $abilities);

        foreach ($abilities as $ability) {
            $isTrue = $user->{$ability}();
            if ($isTrue) {
                return true;
            }
        }

        return false;
    }
}
