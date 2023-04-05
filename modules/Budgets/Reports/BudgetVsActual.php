<?php

namespace Modules\Budgets\Reports;

use App\Abstracts\Report;
use Illuminate\Database\Eloquent\Builder;
use Modules\Budgets\Models\Budget;
use Modules\Budgets\Support\BudgetSupport;
use Modules\Budgets\Support\FinancialYear;
use Modules\DoubleEntry\Models\DEClass;

class BudgetVsActual extends Report
{
    /** @var string */
    public $default_name = 'budgets::general.budget_vs_actual';

    /** @var string */
    public $category = 'general.accounting';

    /** @var string */
    public $icon = 'account_balance_wallet';

    /** @var \Modules\Budgets\Models\Budget */
    public $budget;

    /** @var \Illuminate\Database\Eloquent\Collection<int, \Modules\DoubleEntry\Models\DEClass> */
    public $doubleEntryClasses;

    public function getGrandTotal()
    {
        if (! $this->loaded) {
            $this->load();
        }

        $total = 0;
        foreach ($this->dates as $date) {
            $total += $this->footer_totals[$this->tables['income']][$date]['over_budget'] - $this->footer_totals[$this->tables['expense']][$date]['over_budget'];
        }

        $total = money($total, setting('default.currency'), true);

        return $total->format();
    }

    public function setTables()
    {
        $this->tables = [
            'income' => trans_choice('general.incomes', 1),
            'expense' => trans_choice('general.expenses', 1),
        ];
    }

    public function setViews()
    {
        parent::setViews();

        $this->views['filter'] = 'budgets::budget_vs_actual.filter';
        $this->views['detail'] = 'budgets::budget_vs_actual.detail';
        $this->views['detail.content.header'] = 'budgets::budget_vs_actual.detail.content.header';
        $this->views['detail.content.footer'] = 'budgets::budget_vs_actual.detail.content.footer';
        $this->views['detail.table'] = 'budgets::budget_vs_actual.detail.table';
        $this->views['detail.table.header'] = 'budgets::budget_vs_actual.detail.table.header';
        $this->views['detail.table.footer'] = 'budgets::budget_vs_actual.detail.table.footer';
        $this->views['detail.table.rows'] = 'budgets::budget_vs_actual.detail.table.rows'; // body
        $this->views['show'] = 'budgets::budget_vs_actual.show';

        $this->loadBudget();
    }

    private function loadBudget(): void
    {
        $this->budget = Budget::query()
            ->where('id', $this->getSetting('budget'))
            ->firstOrFail();

        $this->doubleEntryClasses = DEClass::query()
            ->where(static function (Builder $query) {
                $query->where('name', 'double-entry::classes.income')
                    ->orWhere('name', 'double-entry::classes.expenses');
            })
            ->with('accounts')
            ->orderBy('name', 'DESC')
            ->get();

        $this->model->settings = (object) ['period' => $this->budget->period];
    }

    public function setData()
    {
        $budgetPeriods = (new FinancialYear())->getBudgetPeriod(
            $this->budget->financial_year,
            $this->budget->period
        );

        /** @var \Modules\DoubleEntry\Models\DEClass $doubleEntryClass */
        foreach ($this->doubleEntryClasses as $doubleEntryClass) {
            $table = $doubleEntryClass->name === 'double-entry::classes.income' ? 'income' : 'expense';

            /** @var \Modules\DoubleEntry\Models\Account $account */
            foreach ($doubleEntryClass->accounts as $account) {
                $this->row_names[$this->tables[$table]][$account->id] = trans($account->name);

                foreach ($this->dates as $index => $date) {
                    $budgetAmount = $this->budget->getBudgetAmount($account, $budgetPeriods[$index]);
                    $actualAmount = $this->budget->getActualAmount($account, $budgetPeriods[$index]);
                    $this->row_values[$this->tables[$table]][$account->id][$date] = $this->calculateRowData($budgetAmount, $actualAmount, $table);
                }
            }

            foreach ($this->dates as $index => $date) {
                $budgetAmountTotal = $this->budget->getTotalBudgetForPeriod($doubleEntryClass, $budgetPeriods[$index]);
                $actualAmountTotal = $this->budget->getTotalActualAmountForPeriod($doubleEntryClass, $budgetPeriods[$index]);
                $this->footer_totals[strtolower($this->tables[$table])][$date] = $this->calculateRowData($budgetAmountTotal, $actualAmountTotal, $table);
            }
        }
    }

    private function calculateRowData(float $budgetAmount, float $actualAmount, string $table): array
    {
        $actualPercentage = BudgetSupport::calculateActualAmountPercentage($actualAmount, $budgetAmount);
        $overBudget = BudgetSupport::calculateOverBudget($actualAmount, $budgetAmount);
        $overBudgetPercentage = BudgetSupport::calculateOverBudgetPercentage($actualAmount, $budgetAmount);
        $overBudgetStyle = null;

        if ($overBudgetPercentage) {
            $overBudgetStyle = BudgetSupport::getOverBudgetStyle($actualAmount, $budgetAmount, $table);
        }

        return [
            'budgeted' => $budgetAmount,
            'actual' => $actualAmount,
            'actual_percentage' => $actualPercentage,
            'over_budget' => $overBudget,
            'over_budget_percentage' => $overBudgetPercentage,
            'over_budget_style' => $overBudgetStyle,
        ];
    }

    public function getFields()
    {
        return [
            $this->getBudgetField(),
        ];
    }

    private function getBudgetField()
    {
        return [
            'type' => 'selectGroup',
            'name' => 'budget',
            'title' => trans_choice('budgets::general.budget', 1),
            'icon' => 'folder',
            'values' => Budget::all()->pluck('name', 'id'),
            'selected' => null,
            'attributes' => [
                'required' => 'required',
            ],
        ];
    }
}
