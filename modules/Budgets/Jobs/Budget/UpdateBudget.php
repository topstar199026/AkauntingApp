<?php

namespace Modules\Budgets\Jobs\Budget;

use App\Abstracts\Job;
use Modules\Budgets\Actions\BudgetActions;
use Modules\Budgets\Models\Budget;

class UpdateBudget extends Job
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
     * @param \Modules\DoubleEntry\Models\Budget $budget
     * @param $request
     * @return void
     */
    public function __construct(Budget $budget, $request)
    {
        $this->budget = $budget;
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
            $this->updateBudget();
            $this->budget->budgetedAmounts()->forceDelete();
            BudgetActions::storeBudgetedAmounts($this->budget, $this->request);
        });

        return $this->budget;
    }

    private function updateBudget()
    {
        $this->budget->name = $this->request->get('name');
        $this->budget->financial_year = $this->request->get('financial_year');
        $this->budget->period = $this->request->get('period');

        $this->budget->save();
    }
}
