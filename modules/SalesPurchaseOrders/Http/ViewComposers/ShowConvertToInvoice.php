<?php

namespace Modules\SalesPurchaseOrders\Http\ViewComposers;

use Illuminate\View\View;

class ShowConvertToInvoice
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
        if ($document->status !== 'invoiced') {
            $description .= trans('sales-purchase-orders::sales_orders.statuses.not_invoiced');
        } else {
            $description .= trans('sales-purchase-orders::sales_orders.statuses.invoiced');
        }

        $view->getFactory()->startPush(
            'get_paid_end',
            view('sales-purchase-orders::fields.show_convert_to_invoice', compact('document', 'description'))
        );
    }

}
