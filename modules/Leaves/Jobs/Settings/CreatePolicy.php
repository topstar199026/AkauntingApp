<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;
use Modules\Leaves\Models\Settings\Policy;

class CreatePolicy extends Job
{
    protected $policy;

    protected $request;

    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    public function handle()
    {
        \DB::transaction(function () {
            $this->policy = Policy::create($this->request->all());
        });

        return $this->policy;
    }
}
