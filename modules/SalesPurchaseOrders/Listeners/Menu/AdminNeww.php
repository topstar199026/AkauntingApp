<?php

namespace Modules\SalesPurchaseOrders\Listeners\Menu;

use Akaunting\Menu\MenuBuilder;
use App\Events\Menu\NewwCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AdminNeww
{
    use Modules;
    use Permissions;

    public function handle(Event $event): void
    {
        if (false === $this->moduleIsEnabled('sales-purchase-orders')) {
            return;
        }

        /** @var MenuBuilder $menu */
        $menu = $event->menu;

        $title = trans_choice('sales-purchase-orders::general.sales_orders', 1);

        if ($this->canAccessMenuItem($title, 'create-sales-purchase-orders-sales-orders')) {
            $menu->route('sales-purchase-orders.purchase-orders.create', $title, [], 8, ['icon' => 'note_add']);
        }

        $title = trans_choice('sales-purchase-orders::general.purchase_orders', 1);

        if ($this->canAccessMenuItem($title, 'create-sales-purchase-orders-purchase-orders')) {
            $menu->route('sales-purchase-orders.purchase-orders.create', $title, [], 38, ['icon' => 'request_quote']);
        }
    }
}
