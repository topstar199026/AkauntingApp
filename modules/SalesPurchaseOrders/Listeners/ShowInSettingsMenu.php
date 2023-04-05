<?php

namespace Modules\SalesPurchaseOrders\Listeners;

use Akaunting\Menu\MenuBuilder;
use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class ShowInSettingsMenu
{
    use Modules;
    use Permissions;

    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if (false === $this->moduleIsEnabled('sales-purchase-orders')) {
            return;
        }

        /** @var MenuBuilder $menu */
        $menu = $event->menu;

        $title = trans_choice('sales-purchase-orders::general.sales_orders', 1);
        if ($this->canAccessMenuItem($title, 'read-sales-purchase-orders-settings-sales-order')) {
            $menu->route(
                'sales-purchase-orders.settings.sales-order.edit',
                $title,
                [],
                28,
                [
                    'icon'            => 'note_add',
                    'search_keywords' => trans('sales-purchase-orders::settings.sales-order.search_keywords'),
                ]
            );
        }

        $title = trans_choice('sales-purchase-orders::general.purchase_orders', 1);
        if ($this->canAccessMenuItem($title, 'read-sales-purchase-orders-settings-purchase-order')) {
            $menu->route(
                'sales-purchase-orders.settings.purchase-order.edit',
                $title,
                [],
                35,
                [
                    'icon'            => 'request_quote',
                    'search_keywords' => trans('sales-purchase-orders::settings.purchase-order.search_keywords'),
                ]
            );
        }
    }
}
