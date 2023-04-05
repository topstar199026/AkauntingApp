<?php

namespace Modules\Receipt\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AdminMenu
{
    use Permissions, Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('receipt')) {
            return;
        }

        $title = trans_choice('receipt::general.menu',2);
        if ($this->canAccessMenuItem($title, 'read-receipt-receipts')) {
            $purchasesMenu = $event->menu->findBy('title', trim(trans_choice('general.purchases', 2)));

            $purchasesMenu->child(
                [
                    'route' => ['receipt.index', []],
                    'title' => $title,
                    'order' => 10,
                ]
            );
        }
    }
}
