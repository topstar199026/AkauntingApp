<?php

namespace Modules\Leaves\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Leaves\Jobs\DeleteEntitlement;
use Modules\Leaves\Models\Entitlement;

class Entitlements extends BulkAction
{
    public $model = Entitlement::class;

    public $text = 'leaves::general.entitlements';

    public $path = [
        'group' => 'leaves',
        'type' => 'entitlements',
    ];

    public $actions = [
        'delete' => [
            'name'       => 'general.delete',
            'message'    => 'bulk_actions.message.delete',
            'permission' => 'delete-leaves-entitlements',
        ],
    ];

    public function destroy($request)
    {
        $entitlements = $this->getSelectedRecords($request, 'allowances');

        foreach ($entitlements as $entitlement) {
            try {
                $this->dispatch(new DeleteEntitlement($entitlement));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
