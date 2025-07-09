<?php

namespace App\Actions\Contracts\Organisation;

use App\Models\Organisation;
use App\Models\User;

final class FetchPrimaryOrgForUser implements FetchPrimaryOrgForUserContract
{
    public function handle(User $user, bool $relation = true): Organisation
    {
        return $user->organisations()
            ->whereIsPrimary(true)
            ->when(
                $relation,
                fn($query) => $query->with([
                    'serviceAreas',
                    'categories',
                    'locations',
                    'preferences',
                    'categories.parent',
                    'categories.parent.parent',
                    'preferences.category',
                    'preferences.prefValues',
                    'preferences.prefValues.states',
                    'preferences.prefValues.suburbs',
                    'otherLocations',
                    'primaryAddress'
                ])
            )->first();
    }
}
