<?php

namespace Modules\Projects\Jobs\Comments;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Comment;

class CreateComment extends Job implements ShouldCreate, HasOwner
{
    /**
     * Execute the job.
     *
     * @return Task
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = Comment::create($this->request->all());
        });

        return $this->model;
    }
}