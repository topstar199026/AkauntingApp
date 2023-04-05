<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class DeleteLeaveType extends Job
{
    protected $leave_type;

    public function __construct($leave_type)
    {
        $this->leave_type = $leave_type;
    }

    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->leave_type->delete();
        });

        return $this->leave_type;
    }

    public function authorize()
    {
        if ($relationships = $this->getRelationships()) {
            $message = trans('messages.warning.deleted', ['name' => $this->leave_type->name, 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships(): array
    {
        $relationships = [
            'policies' => 'leaves::general.policies',
        ];

        return $this->countRelationships($this->leave_type, $relationships);
    }
}
