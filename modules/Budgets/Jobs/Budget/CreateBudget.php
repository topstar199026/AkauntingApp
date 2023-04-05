<?php

namespace Modules\Budgets\Jobs\Budget;

use App\Abstracts\Job;
use App\Models\Common\Company;
use Modules\Budgets\Actions\BudgetActions;
use Modules\Budgets\Models\Budget;

class CreateBudget extends Job
{
    protected $request;

    /**
     * The account instance.
     *
     * @var \Modules\Budgets\Models\Budget
     */
    protected $budget;

    /**
     * Create a new job instance.
     *
     * @param $request
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Budget
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->budget = $this->createBudget();
            BudgetActions::storeBudgetedAmounts($this->budget, $this->request);
        });

        return $this->budget;
    }

    private function createBudget(): Budget
    {
        $budget = new Budget();

        $budget->name = $this->request->get('name');
        $budget->financial_year = $this->request->get('financial_year');
        $budget->period = $this->request->get('period');
        $budget->company()->associate(Company::getCurrent());

        $budget->save();

        return $budget;
    }
}
