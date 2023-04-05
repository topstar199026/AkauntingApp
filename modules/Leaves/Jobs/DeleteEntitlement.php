<?php

namespace Modules\Leaves\Jobs;

use App\Abstracts\Job;
use Modules\Leaves\Models\Allowance;
use Modules\Leaves\Models\Entitlement;

class DeleteEntitlement extends Job
{
    protected $entitlement;

    public function __construct($entitlement)
    {
        $this->entitlement = $entitlement;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $this->authorize();

        \DB::transaction(function () {
            $this->entitlement->delete();
        });

        return $this->entitlement;
    }

    /**
     * @throws \Exception
     */
    public function authorize()
    {
        if ($relationships = $this->getRelationships()) {
            $message = trans('messages.warning.deleted', ['name' => trans_choice('leaves::general.entitlements', 1), 'text' => implode(', ', $relationships)]);

            throw new \Exception($message);
        }
    }

    public function getRelationships(): array
    {
        $counter = [];

        $leaves_query = $this->entitlement->allowances()->used();

        if ($c = $leaves_query->count()) {
            $counter[] = $c . ' ' . strtolower(trans_choice('leaves::general.leaves', ($c > 1) ? 2 : 1));
        }

        return $counter;
    }
}
