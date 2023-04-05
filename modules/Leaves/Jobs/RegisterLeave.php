<?php

namespace Modules\Leaves\Jobs;

use App\Abstracts\Job;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Leaves\Models\Allowance;

class RegisterLeave extends Job
{
    protected $allowance;

    protected $request;

    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    public function handle()
    {
        DB::transaction(function () {
            $this->allowance = Allowance::create([
                'company_id'     => $this->request['company_id'],
                'entitlement_id' => $this->request['entitlement_id'],
                'employee_id'    => $this->request['employee_id'],
                'start_date'     => $this->request['start_date'],
                'end_date'       => $this->request['end_date'],
                'type'           => Allowance::TYPE_USED,
                'days'           => Carbon::parse($this->request['end_date'])->diffInDays($this->request['start_date']) + 1,
            ]);
        });

        return $this->allowance;
    }
}
