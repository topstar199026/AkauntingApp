<?php

namespace Modules\Leaves\Jobs;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;
use Modules\Leaves\Models\Allowance;

class AllowLeave extends Job
{
    protected $entitlement;

    protected $allowance;

    public function __construct($entitlement)
    {
        $this->entitlement = $entitlement;
    }

    public function handle()
    {
        DB::transaction(function () {
            $this->allowance = Allowance::create([
                'company_id'     => $this->entitlement->company_id,
                'entitlement_id' => $this->entitlement->id,
                'employee_id'    => $this->entitlement->employee_id,
                'type'           => Allowance::TYPE_ALLOWED,
                'days'           => $this->entitlement->policy->days,
            ]);
        });

        return $this->allowance;
    }
}
