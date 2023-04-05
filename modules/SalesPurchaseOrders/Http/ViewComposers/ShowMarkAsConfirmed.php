<?php

namespace Modules\SalesPurchaseOrders\Http\ViewComposers;

use Illuminate\View\View;

class ShowMarkAsConfirmed
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $document = $view->getData()['salesOrder'];

        $description = trans_choice('general.statuses', 1) . ': ';
        if ($document->status !== 'confirmed') {
            $description .= trans('sales-purchase-orders::sales_orders.statuses.not_confirmed');
        } else {
            $description .= trans('sales-purchase-orders::sales_orders.statuses.confirmed');
        }

        $view->getFactory()->startPush(
            'get_paid_start',
            view('sales-purchase-orders::fields.show_mark_as_confirmed', compact('document', 'description'))
        );
    }

}
