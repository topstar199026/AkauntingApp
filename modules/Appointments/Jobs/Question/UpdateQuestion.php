<?php

namespace Modules\Appointments\Jobs\Question;

use App\Abstracts\Job;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Models\QuestionValue;

class UpdateQuestion extends Job
{
    protected $request;

    protected $question;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($question, $request)
    {
        $this->question = $question;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Slot
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->question->update($this->request->all());
            if ($this->question->question_type == true) {
                QuestionValue::where('question_id', $this->question->id)->delete();
                foreach ($this->request['items'] as $item) {
                    $question_value = QuestionValue::create([
                        'company_id' => $this->question->company_id,
                        'question_id' => $this->question->id,
                        'avaible_answer' => $item['avaible_answer'],
                    ]);
                }
            }
        });

        return $this->question;
    }
}
