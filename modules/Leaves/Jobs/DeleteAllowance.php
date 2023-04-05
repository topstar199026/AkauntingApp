<?php

namespace Modules\Leaves\Jobs;

use App\Abstracts\Job;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteAllowance extends Job
{
    protected $allowance;

    public function __construct($allowance)
    {
        $this->allowance = $allowance;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->allowance->delete();
        });

        return $this->allowance;
    }
}
