<?php

namespace App\Listeners;

use App\Events\ClientAction;
use App\Notifications\ClientActionNotification;

class ClientActionNotify
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param ClientAction $event
     */
    public function handle(clientAction $event)
    {
        $client = $event->getClient();
        $action = $event->getAction();

        $client->assignedUser->notify(new clientActionNotification(
            $client,
            $action
        ));
    }
}
