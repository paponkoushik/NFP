<?php

namespace App\Actions\Contracts\Organisation;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface FetchPrimaryOrgForUserContract
{
    public function handle(User $user, bool $relation = true): Organisation;
}