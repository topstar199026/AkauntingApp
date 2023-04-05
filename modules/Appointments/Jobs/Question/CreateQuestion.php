<?php

namespace Modules\Appointments\Jobs\Question;

use App\Abstracts\Job;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Models\QuestionValue;

class CreateQuestion extends Job
{
    protected $request;

    protected $question;

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
     * @return Question
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->question = Question::create($this->request->all());
            if ($this->question->question_type == true) {
                foreach ($this->request['items'] as $item) {
                    $question_value = QuestionValue::create([
                        'company_id' => $this->request->company_id,
                        'question_id' => $this->question->id,
                        'avaible_answer' => $item['avaible_answer'],
                    ]);
                }
            }
        });

        return $this->question;
    }
}
