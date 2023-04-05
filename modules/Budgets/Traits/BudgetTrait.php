<?php

namespace Modules\Budgets\Traits;

use Carbon\Carbon;
use Modules\DoubleEntry\Models\Account;
use Modules\DoubleEntry\Models\DEClass;

trait BudgetTrait
{
    public function getBudgetAmount(Account $account, array $period): float
    {
        if (! $this->budgetedAmounts) {
            return 0;
        }

        $budgeted = $this->budgetedAmounts->first(function ($budget) use ($account, $period) {
            return (
                $budget->account_id === $account->id
                && $budget->start_date->eq(Carbon::create($period['start_date']))
                && $budget->end_date->eq(Carbon::create($period['end_date']))
            );
        });

        return $budgeted->amount ?? 0;
    }

    public function getActualAmount(Account $account, array $period): float
    {
        $account->start_date = $period['start_date'];
        $account->end_date = $period['end_date'];

        return abs($account->balance);
    }

    public function getTotalBudgetForPeriod(DEClass $deClass, array $period): float
    {
        $total = 0;

        $deClass->accounts->each(function ($account) use (&$total, $period) {
            $total = $total + floatval($this->getBudgetAmount($account, $period));
        });

        return $total;
    }

    public function getTotalActualAmountForPeriod(DEClass $deClass, array $period): float
    {
        $total = 0;

        $deClass->accounts->each(function ($account) use (&$total, $period) {
            $total = $total + floatval($this->getActualAmount($account, $period));
        });

        return $total;
    }
}