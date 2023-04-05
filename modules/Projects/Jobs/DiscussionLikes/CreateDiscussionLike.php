<?php

namespace Modules\Projects\Jobs\DiscussionLikes;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\DiscussionLike;

class CreateDiscussionLike extends Job implements ShouldCreate, HasOwner
{
    /**
     * Execute the job.
     *
     * @return Task
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = DiscussionLike::create($this->request->all());
        });

        return $this->model;
    }
}