<?php

namespace Modules\Proposals\Jobs\Templates;

use App\Abstracts\Job;

class UpdateTemplate extends Job
{
    protected $template;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $request)
    {
        $this->template = $template;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->template->update($this->request->all());

        return $this->template;
    }
}
