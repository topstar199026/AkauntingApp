<?php

namespace Modules\SalesPurchaseOrders\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use App\Jobs\Document\SendDocumentAsCustomMail;
use App\Http\Requests\Common\CustomMail as Request;
use Illuminate\Http\JsonResponse;
use Modules\SalesPurchaseOrders\Models\PurchaseOrder\Model;
use Modules\SalesPurchaseOrders\Notifications\PurchaseOrder as Notification;

class PurchaseOrdersEmails extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-sales-purchase-orders-purchase-orders')->only('create', 'store');
    }

    public function create(Model $purchaseOrder): JsonResponse
    {
        $notification = new Notification($purchaseOrder, 'purchase_order_new_vendor', true);

        $html = view('sales-purchase-orders::purchase_orders.modals.email', compact('purchaseOrder', 'notification'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => $html,
            'data'    => [
                'title'   => trans('general.title.new', ['type' => trans_choice('general.email', 1)]),
                'buttons' => [
                    'cancel'  => [
                        'text'  => trans('general.cancel'),
                        'class' => 'btn-outline-secondary',
                    ],
                    'confirm' => [
                        'text'  => trans('general.send'),
                        'class' => 'disabled:bg-green-100',
                    ],
                ],
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new SendDocumentAsCustomMail($request, 'purchase_order_new_vendor'));

        if ($response['success']) {
            $purchaseOrder = Model::find($request->get('document_id'));

            $response['redirect'] = route('sales-purchase-orders.purchase-orders.show', $purchaseOrder->id);

            $message = trans(
                'documents.messages.email_sent',
                ['type' => trans_choice('sales-purchase-orders::general.purchase_orders', 1)]
            );

            flash($message)->success();
        } else {
            $response['redirect'] = null;
        }

        return response()->json($response);
    }
}
