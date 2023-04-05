<?php

namespace Modules\Budgets\Jobs\Budget;

use App\Abstracts\Job;
use Modules\Budgets\Models\Budget;

class DeleteBudget extends Job
{
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
     * @return void
     */
    public function __construct($budget)
    {
        $this->budget = $budget;
    }

    /**
     * Execute the job.
     *
     * @return Budget
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->budget->delete();

            $this->budget->budgetedAmounts()->delete();
        });

        return $this->budget;
    }
}