<?php

namespace Modules\Projects\Jobs\Financials;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Financial;

class CreateFinancial extends Job implements ShouldCreate
{

    /**
     * Execute the job.
     *
     * @return Financial
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = Financial::create($this->request->all());
        });

        return $this->model;
    }
}
