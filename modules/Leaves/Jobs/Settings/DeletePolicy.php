<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class DeletePolicy extends Job
{
    protected $policy;

    public function __construct($policy)
    {
        $this->policy = $policy;
    }

    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->policy->delete();
        });

        return $this->policy;
    }

    public function authorize()
    {
        if ($relationships = $this->getRelationships()) {
            $message = trans('messages.warning.deleted', ['name' => $this->policy->name, 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships(): array
    {
        $relationships = [
            'entitlements' => 'entitlements',
        ];

        return $this->countRelationships($this->policy, $relationships);
    }
}
