<?php

namespace Modules\Proposals\Jobs\Proposals;

use App\Abstracts\Job;

class UpdateProposal extends Job
{
    protected $proposal;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($proposal, $request)
    {
        $this->proposal = $proposal;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->proposal->update($this->request->all());

        return $this->proposal;
    }
}
