<?php

namespace Modules\Proposals\Jobs\Pipelines;

use App\Abstracts\Job;

class UpdatePipeline extends Job
{
    protected $pipeline;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pipeline, $request)
    {
        $this->pipeline = $pipeline;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->pipeline->update($this->request->all());

        return $this->pipeline;
    }
}
