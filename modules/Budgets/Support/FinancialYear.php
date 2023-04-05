<?php

namespace Modules\Budgets\Support;

use App\Traits\DateTime;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Modules\Budgets\Models\Budget;

class FinancialYear
{
    use DateTime;

    public function getFinancialYears($numberOfYears = 5): array
    {
        $financialYears = [];
        $currentYear = now()->year;

        for ($i = 0; $i < $numberOfYears; $i++) {
            $year = $currentYear + $i;
            $financialYear = $this->getFinancialYear($year);
            $financialYears[$year] = $financialYear->getStartDate()->format('M Y') . ' - ' . $financialYear->getEndDate()->format('M Y');
        }

        return $financialYears;
    }

    public function getFinancialMonthly($year = null): array
    {
        $months = [];
        $start = $this->getFinancialStart($year);

        for ($i = 0; $i < 12; $i++) {
            $months[] = CarbonPeriod::create($start->copy()->addMonths($i), $start->copy()->addMonths($i + 1)->subDay()->endOfDay());
        }

        return $months;
    }

    public function getBudgetPeriod($financialYear, $periodType): Collection
    {
        $budgetPeriod = [];

        switch ($periodType) {
            case Budget::PERIOD_MONTHLY:
                $budgetPeriod = $this->getFinancialMonthly($financialYear);
                break;
            case Budget::PERIOD_QUARTERLY:
                $budgetPeriod = $this->getFinancialQuarters($financialYear);
                break;
            case Budget::PERIOD_YEARLY:
                $budgetPeriod = [$this->getFinancialYear($financialYear)];
                break;
        }

        return collect($budgetPeriod)->map(function ($date) {
            return [
                'start_date' => $date->getStartDate()->format('Y-m-d'),
                'end_date' => $date->getEndDate()->format('Y-m-d'),
            ];
        });
    }
}
