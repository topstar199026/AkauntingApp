<?php

namespace Modules\Proposals\Jobs\Proposals;

use App\Abstracts\Job;

class DeleteProposal extends Job
{
    protected $proposal;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->proposal->delete();

        return true;
    }
}
