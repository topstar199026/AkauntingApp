<?php

namespace Modules\SalesPurchaseOrders\Listeners\Menu;

use Akaunting\Menu\MenuBuilder;
use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class Admin
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

        $title = trans_choice('sales-purchase-orders::general.sales_orders', 2);
        if ($this->canAccessMenuItem($title, 'read-sales-purchase-orders-sales-orders')) {
            $salesMenu = $menu->findBy('title', trim(trans_choice('general.sales', 2)));


            $salesMenu->child(
                [
                    'route' => ['sales-purchase-orders.sales-orders.index', []],
                    'title' => $title,
                    'order' => 8,
                ]
            );
        }

        $title = trans_choice('sales-purchase-orders::general.purchase_orders', 2);
        if ($this->canAccessMenuItem($title, 'read-sales-purchase-orders-purchase-orders')) {
            $purchasesMenu = $event->menu->findBy('title', trim(trans_choice('general.purchases', 2)));


            $purchasesMenu->child(
                [
                    'route' => ['sales-purchase-orders.purchase-orders.index', []],
                    'title' => $title,
                    'order' => 5,
                ]
            );
        }
    }
}
