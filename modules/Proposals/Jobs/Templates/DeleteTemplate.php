<?php

namespace Modules\Proposals\Jobs\Templates;

use App\Abstracts\Job;

class DeleteTemplate extends Job
{
    protected $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->template->delete();

        return true;
    }
}
