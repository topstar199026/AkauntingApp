<?php

namespace Modules\Budgets\Actions;

use App\Models\Common\Company;
use Modules\Budgets\Models\Budget;
use Modules\Budgets\Models\BudgetedAmount;

class BudgetActions
{
    public static function storeBudgetedAmounts(Budget $budget, $request)
    {
        if (!$request->has('budgeted_amounts')) {
            return;
        }

        $budgeted_amounts = json_decode($request->get('budgeted_amounts'), true);

        foreach ($budgeted_amounts as $budgetTypes) {
            foreach ($budgetTypes as $budgeted) {
                foreach ($budgeted as $budgetData) {
                    self::createBudgetAmount($budget, $budgetData);
                }
            }
        }
    }

    private static function createBudgetAmount(Budget $budget, array $budgetData): void
    {
        if (empty($budgetData['account_id']) || empty($budgetData['start_date']) || empty($budgetData['end_date']) || (float) $budgetData['amount'] <= 0) {
            return;
        }

        $budgetedAmount = new BudgetedAmount();

        $budgetedAmount->budget()->associate($budget);
        $budgetedAmount->company()->associate(Company::getCurrent());

        $budgetedAmount->account_id = $budgetData['account_id'];
        $budgetedAmount->amount = floatval($budgetData['amount']);
        $budgetedAmount->start_date = $budgetData['start_date'];
        $budgetedAmount->end_date = $budgetData['end_date'];

        $budgetedAmount->save();
    }
}
