<?php

namespace App\Actions\Contracts\Mailable;

use App\Mail\LegalSupportAdminsMailable;
use App\Mail\LegalSupportUserMailable;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

final class SendLegalSupportMail implements SendMailableContract
{
    /**
     * Send legal support mail
     */
    public function send(User $user, ...$legalRequest): self
    {
        Mail::to($user)->send(new LegalSupportUserMailable($user, $legalRequest[0]));

        [$to, $cc] = User::legalAdminEmails();

        Mail::to($to)
            ->cc($cc)
            ->send(new LegalSupportAdminsMailable($user, $legalRequest[0]));

        return $this;
    }
}
