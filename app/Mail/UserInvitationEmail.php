<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class UserInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user associated with the mail.
     *
     * @var array
     */
    public $user;

    /**
     * The link to verify user account.
     *
     * @var array
     */
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->url = config('app.url') . '/verify/account/' . $this->user['invitation_token'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('app.name').': Complete your account setup',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
//            view: 'emails.user-invitation',
            markdown: 'emails.user-invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
