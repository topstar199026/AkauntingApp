<?php

namespace Modules\Leaves\Jobs\Settings;

use App\Abstracts\Job;

class UpdatePolicy extends Job
{
    protected $policy;

    protected $request;

    public function __construct($policy, $request)
    {
        $this->policy = $policy;
        $this->request = $this->getRequestInstance($request);
    }

    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->policy->update($this->request->all());
        });

        return $this->policy;
    }

    public function authorize()
    {
        if (!$relationships = $this->getRelationships()) {
            return;
        }

        if ($this->request->has('leave_type_id') && ($this->request->get('leave_type_id') != $this->policy->leave_type_id)) {
            $message = trans('leaves::messages.error.change_leave_type', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }

        if ($this->request->has('leave_year_id') && ($this->request->get('leave_year_id') != $this->policy->leave_year_id)) {
            $message = trans('leaves::messages.error.change_leave_year', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }

        if ($this->request->has('days') && ($this->request->get('days') != $this->policy->days)) {
            $message = trans('leaves::messages.error.change_days', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }

        if ($this->request->has('applicable_after') && ($this->request->get('applicable_after') != $this->policy->applicable_after)) {
            $message = trans('leaves::messages.error.change_applicable_after', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }

        if ($this->request->has('carryover_days') && ($this->request->get('carryover_days') != $this->policy->carryover_days)) {
            $message = trans('leaves::messages.error.change_carryover_days', ['text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships(): array
    {
        $relationships = [
            'entitlements' => 'leaves::general.entitlements',
        ];

        return $this->countRelationships($this->policy, $relationships);
    }
}
