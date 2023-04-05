<?php

namespace Modules\Estimates\Http\ViewComposers;

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
        $document = $view->getData()['estimate'];

        $description = trans_choice('general.statuses', 1) . ': ';
        if ($document->status !== 'invoiced') {
            $description .= trans('documents.statuses.not_invoiced');
        } else {
            $description .= trans('documents.statuses.invoiced');
        }

        $view->getFactory()->startPush(
            'get_paid_end',
            view('estimates::fields.show_convert_to_invoice', compact('document', 'description'))
        );
    }

}
