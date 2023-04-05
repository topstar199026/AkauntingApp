<?php

namespace Modules\Projects\Jobs\Financials;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteFinancial extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return boolean|Exception
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model->delete();
        });

        return true;
    }
}
