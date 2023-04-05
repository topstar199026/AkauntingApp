<?php

namespace Modules\Budgets\Support;

class BudgetSupport
{
    public static function calculateOverBudget($actualAmount, $budgetAmount): float
    {
        return floatval($actualAmount) - floatval($budgetAmount);
    }

    public static function calculateOverBudgetPercentage($actualAmount, $budgetAmount): ?float
    {
        if ($budgetAmount === 0.0) {
            return null;
        }

        return (self::calculateOverBudget($actualAmount, $budgetAmount) / floatval($budgetAmount)) * 100;
    }

    public static function calculateActualAmountPercentage($actualAmount, $budgetAmount): ?float
    {
        if ($budgetAmount === 0.0) {
            return null;
        }

        return (floatval($actualAmount) / floatval($budgetAmount)) * 100;
    }

    public static function getOverBudgetStyle($actualAmount, $budgetAmount, $type): string
    {
        if (strtolower($type) === 'income') {
            $overBudgetStyle = $actualAmount >= $budgetAmount ? 'text-green-500' : 'text-red-500';
        } else {
            $overBudgetStyle = $actualAmount > $budgetAmount ? 'text-red-500' : 'text-green-500';
        }

        return $overBudgetStyle;
    }
}
