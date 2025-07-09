<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The request array associated with the event.
     * 
     * @var array
     */
    public $request;

    /**
     * The organisationId of the event.
     * 
     * @var char
     */
    public $organisationId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $organisationId)
    {
        $this->request = $request;
        $this->organisationId = $organisationId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
