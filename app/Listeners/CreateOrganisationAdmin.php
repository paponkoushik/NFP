<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Events\OrganisationCreated;
use Illuminate\Queue\InteractsWithQueue;
use App\Actions\Repository\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrganisationAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrganisationCreated  $event
     * @return void
     */
    public function handle(OrganisationCreated $event)
    {
        $request = $event->request;

        $request['email'] = $request['contact_email'];
        $request['organisation_id'] = $event->organisationId;
//        $request['role'] = ('client' == $request['org_type']) ? 'client_admin' : 'legal_admin';
        $request['role'] = 'org-admin';

        $user = (new UserRepository)->registerUser($request);
    }
}
