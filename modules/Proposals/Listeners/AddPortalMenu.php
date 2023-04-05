<?php

namespace Modules\Proposals\Listeners;

use App\Events\Menu\PortalCreated as Event;

class AddPortalMenu
{
    /**
     * Handle the event.
     *
     * @param PortalCreated $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! user()->can(['read-proposals-portal-proposals'])) {
            return;
        }

        if (!module('estimates')) {
            return;
        }

        $event->menu->route(
            'portal.proposals.proposals.index',
            trans_choice('proposals::general.proposals', 2),
            [],
            14,
            ['icon' => 'request_page']
        );
    }
}
