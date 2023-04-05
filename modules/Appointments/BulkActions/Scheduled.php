<?php

namespace Modules\Appointments\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Appointments\Models\Scheduled as Model;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;

class Scheduled extends BulkAction
{
    public $model = Model::class;

    public $text = 'appointments::general.scheduled';

    public $path = [
        'group' => 'appointments',
        'type'  => 'scheduled',
    ];

    public $actions = [
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'appointments', 'type' => 'scheduled'],
            'type' => '*',
            'permission' => 'delete-appointments-scheduled',
        ],
    ];

    public function destroy($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new UpdateScheduled($item));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
