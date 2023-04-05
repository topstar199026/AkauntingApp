<?php

namespace Modules\Budgets\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Models\Module\Module;

class AddMenu
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        $module = Module::alias('budgets')->enabled()->first();

        if (! $module) {
            return;
        }

        $title = trim(trans('budgets::general.name'));
        $event->menu->route(
            'budgets.index', $title, [], 52, ['icon' => 'account_balance_wallet']
        );
    }
}
