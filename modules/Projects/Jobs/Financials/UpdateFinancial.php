<?php

namespace Modules\Projects\Jobs\Financials;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Illuminate\Support\Facades\DB;

class UpdateFinancial extends Job implements ShouldUpdate
{
    /**
     * Execute the job.
     *
     * @return Financial
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model->update($this->request->all());
        });

        return $this->model;
    }
}
