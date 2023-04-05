<?php

namespace Modules\Leaves\Jobs;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;
use Modules\Leaves\Models\Entitlement;

class CreateEntitlement extends Job
{
    protected $entitlements;

    protected $request;

    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    public function handle()
    {
        DB::transaction(function () {
            foreach ($this->request->input('employees') as $employee_id) {
                $entitlement = Entitlement::create([
                    'company_id'  => $this->request->input('company_id'),
                    'policy_id'   => $this->request->input('policy_id'),
                    'employee_id' => $employee_id,
                ]);

                $this->dispatch(new AllowLeave($entitlement));

                $this->entitlements[] = $entitlement;
            }
        });

        return $this->entitlements;
    }
}
