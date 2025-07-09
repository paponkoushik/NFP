<?php

namespace App\Models\Traits;

use App\Enums\UserRoles;

trait HasRole
{
    /**
     * Check if the user has given role.
     *
     * @param string | array $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_null($role) || empty($role)) {
            return false;
        }
        $roles = explode(':', $this->actingAs($this->role));

        if (is_string($role)) {
            if (!$roles) {
                return false;
            }

            return in_array($role, $roles);
        }

        if (is_array($role)) {
            foreach ($role as $r) {
                if ($this->hasRole($r)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if user has super admin role.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->actingAs($this->role) === UserRoles::SuperAdmin->value;
    }

    /**
     * Check if user has super admin or admin role.
     *
     * @return bool
     */
    public function isAdmins()
    {
        return $this->isSuperAdmin() || $this->isNfpAdmin();
    }

    /**
     * Check if user has nfp admin role.
     *
     * @return bool
     */
    public function isNfpAdmin()
    {
        return $this->actingAs($this->role) === UserRoles::NfpAdmin->value;
    }

    /**
     * Check if user has org admin role.
     *
     * @return bool
     */
    public function isOrgAdmin()
    {
        return $this->actingAs($this->role) === UserRoles::OrgAdmin->value;
    }

    /**
     * Check if user has client admin role.
     *
     * @return bool
     */
    public function isClientAdmin()
    {
        return $this->actingAs($this->role) === UserRoles::ClientAdmin->value;
    }

    /**
     * Check if user has Individual role.
     *
     * @return bool
     */
    public function isIndividual()
    {
        return $this->actingAs($this->role) === UserRoles::Individual->value;
    }

    /**
     * Check if user has legal admin role.
     *
     * @return bool
     */
    public function isLegalAdmin()
    {
        return $this->actingAs($this->role) === UserRoles::LegalAdmin->value;
    }

    /**
     * Check if user has lawyer role.
     *
     * @return bool
     */
    public function isLawyer()
    {
        return $this->actingAs($this->role) === UserRoles::Lawyer->value;
    }

    /**
     * Check if user has user role.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->actingAs($this->role) === 'user';
    }

    /**
     * Check if logged in user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get impersonate or logged in user role.
     *
     * @param  string $role
     * @return string
     */
    public function actingAs($role)
    {
        if (session()->has('impersonateUser')) {
            return session('impersonateUser.role');
        }

        return $role;
    }
}
