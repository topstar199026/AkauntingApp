<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;
use Modules\Leaves\Models\Settings\Year;

class CreateYear extends Job
{
    protected $year;

    protected $request;

    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
        $this->request->merge(['created_by' => user_id()]);
    }

    public function handle()
    {
        \DB::transaction(function () {
            $this->year = Year::create($this->request->all());
        });

        return $this->year;
    }
}
