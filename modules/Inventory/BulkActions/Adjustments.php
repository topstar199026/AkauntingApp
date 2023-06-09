<?php

namespace Modules\Inventory\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Inventory\Models\Adjustment;
use Modules\Inventory\Jobs\Adjustments\DeleteAdjustment;

class Adjustments extends BulkAction
{
    public $model = Adjustment::class;

    public $text = 'inventory::general.adjustments';

    public $path = [
        'group' => 'inventory',
        'type' => 'adjustments',
    ];

    public $actions = [
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'inventory', 'type' => 'adjustments'],
            'type' => '*',
            'permission' => 'delete-inventory-adjustments',
        ],
    ];

    public function destroy($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new DeleteAdjustment($item));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
