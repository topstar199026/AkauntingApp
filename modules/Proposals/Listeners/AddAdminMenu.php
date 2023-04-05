<?php
namespace Modules\Proposals\Listeners;

use App\Events\Menu\AdminCreated as Event;

class AddAdminMenu
{
    /**
     * Handle the event.
     *
     * @param AdminMenuCreated $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! user()->can('read-proposals-proposals')) {
            return;
        }

        $salesMenu = $event->menu->findBy('title', trim(trans_choice('general.sales', 2)));
        
        $salesMenu->child(
            [
                'url' => route('proposals.proposals.index'),
                'title' => trans('proposals::general.name'),
                'order' => 4,
            ]
        );
    }
}
