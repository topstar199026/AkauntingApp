<?php

namespace Modules\SalesPurchaseOrders\Http\ViewComposers;

use Illuminate\View\View;

class ShowMarkAsIssued
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
        $document = $view->getData()['purchaseOrder'];

        $description = trans_choice('general.statuses', 1) . ': ';
        if ($document->status !== 'issued') {
            $description .= trans('sales-purchase-orders::purchase_orders.statuses.not_issued');
        } else {
            $description .= trans('sales-purchase-orders::purchase_orders.statuses.issued');
        }

        $view->getFactory()->startPush(
            'get_paid_start',
            view('sales-purchase-orders::fields.show_mark_as_issued', compact('document', 'description'))
        );
    }

}
