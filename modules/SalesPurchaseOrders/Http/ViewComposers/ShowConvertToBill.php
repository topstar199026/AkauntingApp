<?php

namespace Modules\SalesPurchaseOrders\Http\ViewComposers;

use Illuminate\View\View;

class ShowConvertToBill
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
        if ($document->status !== 'billed') {
            $description .= trans('sales-purchase-orders::purchase_orders.statuses.not_billed');
        } else {
            $description .= trans('sales-purchase-orders::purchase_orders.statuses.billed');
        }

        $view->getFactory()->startPush(
            'get_paid_end',
            view('sales-purchase-orders::fields.show_convert_to_bill', compact('document', 'description'))
        );
    }

}
