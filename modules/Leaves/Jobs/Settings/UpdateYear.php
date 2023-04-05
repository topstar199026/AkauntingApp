<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class UpdateYear extends Job
{
    protected $year;

    protected $request;

    public function __construct($year, $request)
    {
        $this->year = $year;
        $this->request = $this->getRequestInstance($request);
    }

    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->year->update($this->request->all());
        });

        return $this->year;
    }

    public function authorize()
    {
        if (!$relationships = $this->getRelationships()) {
            return;
        }

        if ($this->request->has('start_date') && ($this->request->get('start_date') != $this->year->start_date)) {
            $message = trans('leaves::messages.error.change_start_date', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }

        if ($this->request->has('end_date') && ($this->request->get('end_date') != $this->year->end_date)) {
            $message = trans('leaves::messages.error.change_end_date', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships()
    {
        $relationships = [
            'policies' => 'policies',
        ];

        return $this->countRelationships($this->year, $relationships);
    }
}
