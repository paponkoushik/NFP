<?php

namespace App\Actions\Contracts\Mailable;

use App\Models\User;

interface SendMailableContract
{
    public function send(User $user, ...$params): self;
}
