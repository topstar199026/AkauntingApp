<?php

namespace Modules\Proposals\Jobs\Templates;

use App\Abstracts\Job;
use Modules\Proposals\Models\Template;

class CreateTemplate extends Job
{
    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Template
     */
    public function handle()
    {
        $template = Template::create($this->request->all());

        return $template;
    }
}
