<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class DeleteYear extends Job
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->year->delete();
        });

        return $this->year;
    }

    public function authorize()
    {
        if ($relationships = $this->getRelationships()) {
            $message = trans('messages.warning.deleted', ['name' => $this->year->name, 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships(): array
    {
        $relationships = [
            'policies' => 'leaves::general.policies',
        ];

        return $this->countRelationships($this->year, $relationships);
    }
}
