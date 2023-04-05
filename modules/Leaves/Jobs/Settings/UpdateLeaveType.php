<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class UpdateLeaveType extends Job
{
    protected $leave_type;

    protected $request;

    public function __construct($leave_type, $request)
    {
        $this->leave_type = $leave_type;
        $this->request = $this->getRequestInstance($request);
    }

    public function handle()
    {
        \DB::transaction(function () {
            $this->leave_type->update($this->request->all());
        });

        return $this->leave_type;
    }
}
