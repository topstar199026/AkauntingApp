<?php

namespace Modules\Proposals\Jobs\Proposals;

use App\Abstracts\Job;
use Modules\Proposals\Models\Proposal;

class CreateProposal extends Job
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
     * @return Proposal
     */
    public function handle()
    {
        $proposal = Proposal::create([
            'company_id' => $this->request->company_id, 
            'description' => $this->request->description,
            'template_id' => $this->request->template_id,
            'estimates_id' => $this->request->estimates_id,
            'content_html' => $this->request->content_html,
            'content_css' => $this->request->content_css,
            'content_components' => $this->request->content_components,
            'content_style' => $this->request->content_style,
        ]);

        return $proposal;
    }
}
