<?php

namespace Modules\Appointments\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Jobs\Question\DeleteQuestion;

class Questions extends BulkAction
{
    public $model = Question::class;

    public $text = 'appointments::general.questions';

    public $path = [
        'group' => 'appointments',
        'type'  => 'questions',
    ];

    public $actions = [
        'enable' => [
            'name' => 'general.enable',
            'message' => 'bulk_actions.message.enable',
            'path' =>  ['group' => 'appointments', 'type' => 'questions'],
            'type' => '*',
            'permission' => 'update-appointments-questions',
        ],
        'disable' => [
            'name' => 'general.disable',
            'message' => 'bulk_actions.message.disable',
            'path' =>  ['group' => 'appointments', 'type' => 'questions'],
            'type' => '*',
            'permission' => 'update-appointments-questions',
        ],
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'appointments', 'type' => 'questions'],
            'type' => '*',
            'permission' => 'delete-appointments-questions',
        ],
    ];

    public function destroy($request)
    {
        $items = $this->getSelectedRecords($request);

        foreach ($items as $item) {
            try {
                $this->dispatch(new DeleteQuestion($item));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
