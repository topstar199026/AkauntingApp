<?php

namespace Modules\Appointments\Jobs\Question;

use App\Abstracts\Job;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Models\QuestionValue;

class DeleteQuestion extends Job
{
    protected $question;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return Question
     */
    public function handle()
    {
        \DB::transaction(function () {
            QuestionValue::where('question_id', $this->question->id)->delete();

            $this->question->delete();
        });

        return true;
    }
}
