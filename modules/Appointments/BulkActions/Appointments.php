<?php

namespace Modules\Appointments\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Jobs\Appointment\DeleteAppointment;

class Appointments extends BulkAction
{
    public $model = Appointment::class;

    public $text = 'appointments::general.appointments';

    public $path = [
        'group' => 'appointments',
        'type'  => 'appointments',
    ];

    public $actions = [
        'enable' => [
            'name' => 'general.enable',
            'message' => 'bulk_actions.message.enable',
            'path' =>  ['group' => 'appointments', 'type' => 'appointments'],
            'type' => '*',
            'permission' => 'update-appointments-appointments',
        ],
        'disable' => [
            'name' => 'general.disable',
            'message' => 'bulk_actions.message.disable',
            'path' =>  ['group' => 'appointments', 'type' => 'appointments'],
            'type' => '*',
            'permission' => 'update-appointments-appointments',
        ],
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'appointments', 'type' => 'appointments'],
            'type' => '*',
            'permission' => 'delete-appointments-appointments',
        ],
    ];

    public function destroy($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new DeleteAppointment($item));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
