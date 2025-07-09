<?php

namespace App\Notifications;

use App\Models\LegalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LegalRequestChanged extends Notification
{
    use Queueable;

    public $legalRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LegalRequest $legalRequest)
    {
        $this->legalRequest = $legalRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Legal Request No: ' . $this->legalRequest->request_no . ' Changed.')
            ->markdown('emails.legal.request-changed');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
