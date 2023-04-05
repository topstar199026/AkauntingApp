<?php

namespace Modules\Appointments\Jobs\Scheduled;

use App\Abstracts\Job;
use Modules\Appointments\Models\Scheduled;

class DeleteScheduled extends Job
{
    protected $scheduled;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scheduled)
    {
        $this->scheduled = $scheduled;
    }

    /**
     * Execute the job.
     *
     * @return Question
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->scheduled->delete();
        });

        return true;
    }
}
