<?php

namespace Modules\Mt940\Listeners;

use App\Events\Menu\AdminCreated as Event;

class ShowAdminMenu
{
    /**
     * Handle the event.
     *
     * @param AdminCreated $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if (user()->cannot('read-mt940')) {
            return;
        }

        $bankingMenu = $event->menu->findBy('title', trim(trans_choice('general.banking', 2)));

        $bankingMenu->child([
            'route' => ['mt940.create', []],
            'title' => trans('mt940::general.title'),
            'order' => 80,
        ]);
    }
}
