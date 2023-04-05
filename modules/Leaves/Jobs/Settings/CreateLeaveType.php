<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;
use Modules\Leaves\Models\Settings\LeaveType;

class CreateLeaveType extends Job
{
    protected $leave_type;

    protected $request;

    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    public function handle()
    {
        \DB::transaction(function () {
            $this->leave_type = LeaveType::create($this->request->all());
        });

        return $this->leave_type;
    }
}
