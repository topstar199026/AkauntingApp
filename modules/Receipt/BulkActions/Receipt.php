<?php

namespace Modules\Receipt\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Receipt\Models\Receipt as ModelReceipt;

class Receipt extends BulkAction
{
    public $model = ModelReceipt::class;

    public $text = 'receipt::general.title';

    public $path = [
        'group' => 'receipt',
        'type' => 'receipt',
    ];

    public $actions = [
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-receipt-receipts',
        ],
    ];

    public function destroy($request)
    {
        $receipts = $this->getSelectedRecords($request);

        foreach ($receipts as $receipt) {
            try {
                $receipt->delete();
            } catch (\Exception $exception) {
                flash($exception->getMessage())->error()->important();
            }
        }
    }
}
