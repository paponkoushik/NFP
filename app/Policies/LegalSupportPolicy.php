<?php

namespace App\Policies;

use App\Enums\LegalReqTypes;
use App\Models\Listing;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LegalSupportPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine if the given legal request can be created by the user.
     */
    public function postSupport(User $user, string $listingId): bool
    {
        return $user->canVisibleToLegalSupport($listingId, LegalReqTypes::Post);
    }

    /**
     * Determine if the given legal request can be created by the user.
     */
    public function orgSupport(User $user, string $orgId): bool
    {
        return $user->canVisibleToLegalSupport($orgId, LegalReqTypes::Org);
    }
}
